<?php

namespace App\Http\Controllers;

use App\Models\Project;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $projects = Project::query()
            ->with('caseStudy:id,project_id,updated_at')
            ->where('is_active', true)->where('has_case_study', true)
            ->where('slug', '!=', 'mapi-shop')
            ->whereHas('caseStudy', fn ($query) => $query->where('is_published', true))
            ->orderBy('slug')->get(['id', 'slug', 'updated_at']);

        return response()->view('sitemap', compact('projects'), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'no-cache',
        ]);
    }
}
