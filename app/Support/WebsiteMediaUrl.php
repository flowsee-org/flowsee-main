<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class WebsiteMediaUrl
{
    public static function for(?string $path): string
    {
        if (! $path) {
            return '';
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $path = ltrim($path, '/');

        // Older portfolio art is committed in public/, while newly uploaded
        // content is stored on Laravel's public storage disk.
        if (str_starts_with($path, 'assets/') || preg_match('/^\d+\.jpg$/i', $path)) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}
