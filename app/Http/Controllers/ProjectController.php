<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\WebsiteMediaUrl;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of active projects (for the homepage portfolio section).
     */
    public function index()
    {
        $projects = Project::with(['service', 'caseStudy'])
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $projectsData = $projects->map(function ($p) {
            return [
                'slug' => $p->slug,
                'name' => $p->name,
                'description' => $p->description,
                'cover_image' => WebsiteMediaUrl::for($p->cover_image),
                'service' => $p->service?->title ?? '',
                'is_featured' => $p->is_featured,
                'has_case_study' => $p->has_case_study,
                'case_study' => $p->caseStudy ? [
                    'title' => $p->caseStudy->title,
                    'lead' => $p->caseStudy->lead,
                    'eyebrow' => $p->caseStudy->eyebrow,
                    'client_name' => $p->caseStudy->client_name,
                    'industry' => $p->caseStudy->industry,
                    'services_provided' => $p->caseStudy->services_provided,
                    'cover_image' => WebsiteMediaUrl::for($p->caseStudy->cover_image),
                    'cover_caption' => $p->caseStudy->cover_caption,
                    'theme_color' => $p->caseStudy->theme_color,
                    'colors' => $p->caseStudy->colors->map(fn($c) => ['name' => $c->name, 'hex' => $c->hex]),
                    'sections' => $p->caseStudy->sections->map(fn($s) => [
                        'title' => $s->title,
                        'lead' => $s->lead,
                        'eyebrow' => $s->eyebrow,
                        'index_label' => $s->index_label,
                        'band_image' => WebsiteMediaUrl::for($s->band_image),
                        'band_caption' => $s->band_caption,
                        'steps' => $s->steps->map(fn($st) => ['title' => $st->title, 'description' => $st->description, 'step_number' => $st->step_number]),
                        'images' => $s->images->map(fn($img) => [
                            'path' => WebsiteMediaUrl::for($img->path),
                            'caption' => $img->caption,
                            'alt' => $img->alt,
                            'layout' => $img->layout,
                        ]),
                    ]),
                ] : null,
                'gallery_images' => $p->galleryImages->map(fn($img) => [
                    'path' => WebsiteMediaUrl::for($img->path),
                    'caption' => $img->caption,
                    'alt' => $img->alt,
                    'layout' => $img->layout,
                ]),
            ];
        })->toJson();

        $serviceIconPaths = [
            'branding' => 'M12 3 3.5 7.5 12 12l8.5-4.5L12 3Zm-8.5 9L12 16.5l8.5-4.5M3.5 16.5 12 21l8.5-4.5',
            'marketing' => 'M21 11.5a8.5 8.5 0 0 1-12.8 7.3L4 21l1.3-4.2A8.5 8.5 0 1 1 21 11.5ZM8.5 11.5h.01M12 11.5h.01M15.5 11.5h.01',
            'video' => 'M4 6h16v12H4zM10 9l5 3-5 3V9Z',
            'packaging' => 'M6 8V3h12v5M6 17H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2m-12-4h12v8H6z',
            'uiux' => 'm8 8-4 4 4 4m8-8 4 4-4 4m-3-11-2 14',
            'academy' => 'M12 3a9 9 0 1 0 9 9h-9V3Zm3-1v6h6a7 7 0 0 0-6-6Z',
        ];

        return view('home', compact('projects', 'projectsData', 'serviceIconPaths'));
    }

    /**
     * Display the specified case study.
     */
    public function show(string $slug)
    {
        $project = Project::with([
            'service',
            'caseStudy',
            'caseStudy.sections',
            'caseStudy.sections.steps',
            'caseStudy.sections.images',
            'caseStudy.colors',
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->where('has_case_study', true)
            ->firstOrFail();

        $caseStudy = $project->caseStudy;

        if (! $caseStudy || ! $caseStudy->is_published) {
            abort(404);
        }

        return redirect()->to('/?case=' . urlencode($project->slug) . '#portfolio');
    }
}
