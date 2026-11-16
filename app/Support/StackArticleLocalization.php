<?php

namespace App\Support;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Lang;

class StackArticleLocalization
{
    /** @var array<string, array<string, string>>|null */
    private static ?array $translations = null;

    /** @return array<string, string>|null */
    public static function translation(string $slug): ?array
    {
        if (self::$translations === null) {
            $translations = Lang::get('stack_articles', [], 'en');
            self::$translations = is_array($translations) ? $translations : [];
        }

        return self::$translations[$slug] ?? null;
    }

    public static function apply(BlogPost $post): BlogPost
    {
        if (app()->getLocale() !== 'en' || ! ($translation = self::translation($post->slug))) {
            return $post;
        }

        $post->setAttribute('title', $translation['title']);
        $post->setAttribute('excerpt', $translation['excerpt']);
        $post->setAttribute('cover_alt', $translation['cover_alt']);
        $post->setAttribute('content', $translation['content']);

        if ($post->relationLoaded('category') && $post->category) {
            $post->category->setAttribute('name', 'Development technologies');
            $post->category->setAttribute('description', 'Practical guides to development tools and software technologies.');
        }

        return $post;
    }
}
