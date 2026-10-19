<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseStudyStep extends Model
{
    use HasFactory;

    protected function description(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => \App\Support\RichTextContent::sanitize($value),
            set: fn ($value) => \App\Support\RichTextContent::sanitize($value),
        );
    }

    protected $fillable = [
        'section_id',
        'title',
        'description',
        'step_number',
        'sort_order',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(CaseStudySection::class);
    }
}
