<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\ColorPalette;
use App\Models\GalleryImage;
use App\Models\Project;
use App\Models\Service;
use App\Support\RichTextContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class StudioSiteContentController extends Controller
{
    private const PRIMARY_STUDIO_ADMIN_EMAIL = 'ceo@flowsee.local';

    public function index(Request $request): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        return response()->json([
            'projects' => Project::query()
                ->with(['service:id,title', 'caseStudy.sections.steps', 'caseStudy.sections.images', 'caseStudy.colors', 'galleryImages'])
                ->orderBy('sort_order')
                ->orderByDesc('created_at')
                ->get(),
            'services' => Service::query()->where('is_active', true)->orderBy('sort_order')->get(['id', 'title']),
        ])->header('Cache-Control', 'private, no-store');
    }

    public function blogIndex(Request $request): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        return response()->json([
            'categories' => BlogCategory::query()->orderBy('sort_order')->get(),
            'posts' => BlogPost::query()->with('category')->orderByDesc('updated_at')->get(),
        ])->header('Cache-Control', 'private, no-store');
    }

    public function storeBlogPost(Request $request): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $data = $request->validate($this->blogPostRules());
        $data['content'] = RichTextContent::sanitize($data['content']);
        $data['published_at'] = $data['published_at'] ?? ($data['is_published'] ? now() : null);
        $post = BlogPost::create($data);

        return response()->json(['post' => $post->load('category')], 201);
    }

    public function updateBlogPost(Request $request, BlogPost $post): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $data = $request->validate($this->blogPostRules($post));
        $data['content'] = RichTextContent::sanitize($data['content']);
        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = $post->published_at ?? now();
        }
        $post->update($data);

        return response()->json(['post' => $post->fresh()->load('category')]);
    }

    public function destroyBlogPost(Request $request, BlogPost $post): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $post->delete();

        return response()->json(['message' => 'مقاله حذف شد.']);
    }

    public function storeProject(Request $request): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $data = $request->validate($this->projectRules());
        $gallery = $data['gallery_images'] ?? [];
        unset($data['gallery_images']);
        $project = DB::transaction(function () use ($data, $gallery): Project {
            $project = Project::create($data);
            $this->syncProjectGallery($project, $gallery);

            return $project;
        });

        return response()->json(['project' => $project->load(['service', 'galleryImages'])], 201);
    }

    public function updateProject(Request $request, Project $project): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $data = $request->validate($this->projectRules($project));
        $gallery = $data['gallery_images'] ?? [];
        unset($data['gallery_images']);
        DB::transaction(function () use ($project, $data, $gallery): void {
            $project->update($data);
            $this->syncProjectGallery($project, $gallery);
        });

        return response()->json(['project' => $project->fresh()->load(['service', 'galleryImages'])]);
    }

    public function destroyProject(Request $request, Project $project): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $project->delete();

        return response()->json(['message' => 'پروژه حذف شد.']);
    }

    public function saveCaseStudy(Request $request, Project $project): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $caseStudy = $project->caseStudy;
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', Rule::unique('case_studies', 'slug')->ignore($caseStudy?->id)],
            'title' => ['required', 'string', 'max:255'],
            'lead' => ['nullable', 'string', 'max:255'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'services_provided' => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'string', 'max:2048'],
            'cover_caption' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'theme_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'is_published' => ['required', 'boolean'],
            'sections' => ['array'],
            'sections.*.slug' => ['required', 'string', 'max:255'],
            'sections.*.title' => ['required', 'string', 'max:255'],
            'sections.*.lead' => ['nullable', 'string', 'max:5000'],
            'sections.*.eyebrow' => ['nullable', 'string', 'max:255'],
            'sections.*.index_label' => ['nullable', 'string', 'max:10'],
            'sections.*.band_image' => ['nullable', 'string', 'max:2048'],
            'sections.*.band_caption' => ['nullable', 'string', 'max:255'],
            'sections.*.steps' => ['array'],
            'sections.*.steps.*.title' => ['required', 'string', 'max:255'],
            'sections.*.steps.*.description' => ['nullable', 'string', 'max:5000'],
            'sections.*.steps.*.step_number' => ['nullable', 'string', 'max:10'],
            'sections.*.images' => ['array'],
            'sections.*.images.*.path' => ['required', 'string', 'max:2048'],
            'sections.*.images.*.caption' => ['nullable', 'string', 'max:500'],
            'sections.*.images.*.alt' => ['nullable', 'string', 'max:255'],
            'sections.*.images.*.layout' => ['required', Rule::in(['full', 'half', 'third'])],
            'colors' => ['array'],
            'colors.*.name' => ['required', 'string', 'max:255'],
            'colors.*.hex' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $sections = $data['sections'] ?? [];
        $colors = $data['colors'] ?? [];
        unset($data['sections'], $data['colors']);

        $caseStudy = DB::transaction(function () use ($project, $caseStudy, $data, $sections, $colors): CaseStudy {
            $caseStudy = $project->caseStudy()->updateOrCreate([], $data);
            $caseStudy->sections()->delete();
            $caseStudy->colors()->delete();

            foreach ($sections as $sectionIndex => $sectionData) {
                $steps = $sectionData['steps'] ?? [];
                $images = $sectionData['images'] ?? [];
                unset($sectionData['steps'], $sectionData['images']);
                $section = $caseStudy->sections()->create($sectionData + ['sort_order' => $sectionIndex]);
                foreach ($steps as $stepIndex => $step) {
                    $section->steps()->create($step + ['sort_order' => $stepIndex]);
                }
                foreach ($images as $imageIndex => $image) {
                    $section->images()->create($image + ['sort_order' => $imageIndex]);
                }
            }

            foreach ($colors as $colorIndex => $color) {
                $caseStudy->colors()->create($color + ['sort_order' => $colorIndex]);
            }

            $project->update(['has_case_study' => true]);

            return $caseStudy;
        });

        return response()->json(['case_study' => $caseStudy->fresh()->load(['sections.steps', 'sections.images', 'colors'])]);
    }

    public function deleteCaseStudy(Request $request, Project $project): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $project->caseStudy()->delete();
        $project->update(['has_case_study' => false]);

        return response()->json(['message' => 'کیس‌استادی حذف شد.']);
    }

    public function uploadImage(Request $request): JsonResponse
    {
        if ($denied = $this->authorizeStudioAdmin($request)) {
            return $denied;
        }

        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        try {
            $image = ImageManager::usingDriver(Driver::class)->decode($data['image']);
            $encoded = $image->encodeUsingFormat(Format::WEBP, quality: 85);
            $path = 'case-studies/'.Str::uuid().'.webp';
            Storage::disk('public')->put($path, (string) $encoded);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['message' => 'تبدیل تصویر به WebP انجام نشد.'], 422);
        }

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'width' => $image->width(),
            'height' => $image->height(),
        ], 201);
    }

    private function projectRules(?Project $project = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($project?->id)],
            'description' => ['nullable', 'string', 'max:2000'],
            'cover_image' => ['required', 'string', 'max:2048'],
            'service_id' => ['nullable', 'integer', 'exists:services,id'],
            'asset_id' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['required', 'boolean'],
            'has_case_study' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'gallery_images' => ['array'],
            'gallery_images.*.path' => ['required', 'string', 'max:2048'],
            'gallery_images.*.caption' => ['nullable', 'string', 'max:500'],
            'gallery_images.*.alt' => ['nullable', 'string', 'max:255'],
            'gallery_images.*.layout' => ['required', Rule::in(['full', 'half', 'third'])],
        ];
    }

    private function blogPostRules(?BlogPost $post = null): array
    {
        return [
            'blog_category_id' => ['required', 'integer', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('blog_posts', 'slug')->ignore($post?->id)],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string', 'max:500000'],
            'cover_image' => [Rule::requiredIf(fn () => (bool) request()->boolean('is_published')), 'nullable', 'string', 'max:2048'],
            'cover_alt' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_featured' => ['required', 'boolean'],
            'is_published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    private function syncProjectGallery(Project $project, array $gallery): void
    {
        $project->galleryImages()->delete();
        foreach ($gallery as $index => $image) {
            $project->galleryImages()->create($image + ['sort_order' => $index]);
        }
    }

    private function authorizeStudioAdmin(Request $request): ?JsonResponse
    {
        $token = $request->bearerToken();
        if (! $token) {
            return response()->json(['message' => 'Studio sign-in required.'], 401);
        }

        try {
            $identityResponse = Http::connectTimeout(3)
                ->timeout(6)
                ->acceptJson()
                ->withToken($token)
                ->get('https://studio.flowsee.ir/api/apps/flowsee-preview/entities/User/me');
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['message' => 'Could not verify Studio session.'], 503);
        }

        if ($identityResponse->status() === 401 || $identityResponse->status() === 403) {
            return response()->json(['message' => 'Studio session expired or invalid.'], 401);
        }
        if (! $identityResponse->successful()) {
            return response()->json(['message' => 'Could not verify Studio session.'], 503);
        }

        $identity = $identityResponse->json();
        if (! is_array($identity) || ($identity['role'] ?? null) !== 'superadmin'
            || ! is_string($identity['email'] ?? null)
            || mb_strtolower($identity['email']) !== self::PRIMARY_STUDIO_ADMIN_EMAIL) {
            return response()->json(['message' => 'Studio superadmin access required.'], 403);
        }

        return null;
    }
}
