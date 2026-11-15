<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class WebsiteMediaUrl
{
    /** Use generated thumbnails only for known public covers; preserve other media URLs. */
    public static function previewFor(?string $path, int $width = 1120): string
    {
        $preview = self::previewBase($path);

        return $preview ? asset($preview.'-'.($width <= 640 ? 640 : 1120).'.webp') : self::for($path);
    }

    public static function previewSrcsetFor(?string $path): ?string
    {
        $preview = self::previewBase($path);

        return $preview ? asset($preview.'-640.webp').' 640w, '.asset($preview.'-1120.webp').' 1120w' : null;
    }

    private static function previewBase(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            $host = strtolower((string) parse_url($path, PHP_URL_HOST));
            if (! in_array($host, ['flowsee.ir', 'www.flowsee.ir'], true)) {
                return null;
            }
            $path = (string) parse_url($path, PHP_URL_PATH);
        }

        return config('website-media.previews', [])[ltrim($path, '/')] ?? null;
    }

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
