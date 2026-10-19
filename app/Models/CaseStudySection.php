<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseStudySection extends Model
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
        'case_study_id',
        'slug',
        'title',
        'lead',
        'eyebrow',
        'index_label',
        'band_image',
        'band_caption',
        'sort_order',
    ];

    public function caseStudy(): BelongsTo
    {
        return $this->belongsTo(CaseStudy::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(CaseStudyStep::class, 'section_id')->orderBy('sort_order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'section_id')->orderBy('sort_order');
    }
}
