<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class LegacyPortfolioSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $marker = 'legacy-portfolio-v1';

        DB::transaction(function () use ($marker): void {
            if (DB::table('website_content_seed_markers')->where('key', $marker)->exists()) {
                return;
            }

            $this->seedServices();
            $this->seedProjects();
            $this->seedCaseStudy();

            // These records were the original public portfolio. Restore their
            // visibility once, while leaving every other Studio-managed field intact.
            Project::query()->whereIn('slug', ['shopero', 'ima', 'exloot', 'ebrahimi'])
                ->update(['is_active' => true]);

            $ebrahimi = Project::query()->where('slug', 'ebrahimi')->firstOrFail();
            $ebrahimi->update(['is_featured' => true, 'has_case_study' => true]);
            CaseStudy::query()->where('project_id', $ebrahimi->id)->update(['is_published' => true]);

            DB::table('website_content_seed_markers')->insert([
                'key' => $marker,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
