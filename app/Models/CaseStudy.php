<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseStudy extends Model
{
    use HasFactory;

    protected function lead(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => \App\Support\RichTextContent::sanitize($value),
            set: fn ($value) => \App\Support\RichTextContent::sanitize($value),
        );
    }

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
