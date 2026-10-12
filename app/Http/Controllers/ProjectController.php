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

        return view('home', compact('projects', 'projectsData'));
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
