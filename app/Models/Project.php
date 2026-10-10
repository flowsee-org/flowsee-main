<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'cover_image',
        'asset_id',
        'is_featured',
        'has_case_study',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'has_case_study' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function caseStudy(): HasOne
    {
        return $this->hasOne(CaseStudy::class);
    }
}
