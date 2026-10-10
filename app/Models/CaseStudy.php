<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'slug',
        'title',
        'lead',
        'eyebrow',
        'client_name',
        'industry',
        'services_provided',
        'cover_image',
        'cover_caption',
        'meta_title',
        'meta_description',
        'theme_color',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(CaseStudySection::class)->orderBy('sort_order');
    }

    public function colors(): HasMany
    {
        return $this->hasMany(ColorPalette::class)->orderBy('sort_order');
    }
}
