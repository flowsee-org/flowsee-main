<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Support\WebsiteMediaUrl;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::query()->orderBy('sort_order')->get();
        $selectedCategory = $request->query('category');
        $category = $selectedCategory
            ? $categories->firstWhere('slug', $selectedCategory)
            : null;

        if ($selectedCategory && ! $category) {
            abort(404);
        }

        $posts = BlogPost::query()
            ->with('category')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->when($category, fn ($query) => $query->where('blog_category_id', $category->id))
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        $pageTitle = $category
            ? $category->name.' | بلاگ استودیو فلوسی'
            : 'بلاگ استودیو فلوسی | ایده‌ها و راهنمای طراحی و رشد';
        $pageDescription = $category?->description
            ?: 'مقاله‌ها، تجربه‌ها و راهنماهای کاربردی استودیو فلوسی دربارهٔ برندینگ، طراحی دیجیتال و بازاریابی.';
        $pageUrl = 'https://flowsee.ir/blog'.($category ? '?category='.$category->slug : '');
        $structuredData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                ['@type' => 'Organization', '@id' => 'https://flowsee.ir/#organization', 'name' => 'استودیو فلوسی', 'url' => 'https://flowsee.ir/'],
                ['@type' => 'WebSite', '@id' => 'https://flowsee.ir/#website', 'url' => 'https://flowsee.ir/', 'name' => 'استودیو فلوسی', 'inLanguage' => 'fa-IR'],
                [
                    '@type' => 'CollectionPage',
                    '@id' => $pageUrl.'#webpage',
                    'url' => $pageUrl,
                    'name' => $pageTitle,
                    'description' => $pageDescription,
                    'isPartOf' => ['@id' => 'https://flowsee.ir/#website'],
                    'about' => ['@id' => 'https://flowsee.ir/#organization'],
                    'inLanguage' => 'fa-IR',
                    'mainEntity' => ['@type' => 'ItemList', 'itemListElement' => $posts->getCollection()->values()->map(fn (BlogPost $post, int $index) => [
                        '@type' => 'ListItem', 'position' => $index + 1, 'url' => route('blog.show', $post->slug),
                    ])->all()],
                ],
            ],
        ];

        return view('blog.index', compact('categories', 'category', 'posts', 'pageTitle', 'pageDescription', 'pageUrl', 'structuredData'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::query()
            ->with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $relatedPosts = BlogPost::query()
            ->with('category')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $pageTitle = $post->meta_title ?: $post->title.' | بلاگ استودیو فلوسی';
        $pageDescription = $post->meta_description ?: ($post->excerpt ?: (string) str(strip_tags($post->content))->squish()->limit(160));
        $pageUrl = route('blog.show', $post->slug);
        $imageUrl = $post->cover_image ? WebsiteMediaUrl::for($post->cover_image) : 'https://flowsee.ir/assets/flowsee-social.jpg';
        $structuredData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                ['@type' => 'Organization', '@id' => 'https://flowsee.ir/#organization', 'name' => 'استودیو فلوسی', 'url' => 'https://flowsee.ir/'],
                ['@type' => 'WebSite', '@id' => 'https://flowsee.ir/#website', 'url' => 'https://flowsee.ir/', 'name' => 'استودیو فلوسی', 'inLanguage' => 'fa-IR'],
                ['@type' => 'BreadcrumbList', '@id' => $pageUrl.'#breadcrumb', 'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'خانه', 'item' => 'https://flowsee.ir/'],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'بلاگ', 'item' => 'https://flowsee.ir/blog'],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => $pageUrl],
                ]],
                ['@type' => 'WebPage', '@id' => $pageUrl.'#webpage', 'url' => $pageUrl, 'name' => $pageTitle, 'description' => $pageDescription, 'isPartOf' => ['@id' => 'https://flowsee.ir/#website'], 'breadcrumb' => ['@id' => $pageUrl.'#breadcrumb'], 'inLanguage' => 'fa-IR'],
                [
                    '@type' => 'BlogPosting',
                    '@id' => $pageUrl.'#article',
                    'mainEntityOfPage' => ['@id' => $pageUrl.'#webpage'],
                    'headline' => $post->title,
                    'description' => $pageDescription,
                    'image' => [$imageUrl],
                    'datePublished' => $post->published_at->toIso8601String(),
                    'dateModified' => $post->updated_at->toIso8601String(),
                    'author' => ['@id' => 'https://flowsee.ir/#organization'],
                    'publisher' => ['@id' => 'https://flowsee.ir/#organization'],
                    'articleSection' => $post->category->name,
                    'inLanguage' => 'fa-IR',
                ],
            ],
        ];

        return view('blog.show', compact('post', 'relatedPosts', 'pageTitle', 'pageDescription', 'pageUrl', 'imageUrl', 'structuredData'));
    }

    public function sitemap()
    {
        $posts = BlogPost::query()
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->get(['slug', 'updated_at']);

        return response()->view('blog.sitemap', compact('posts'), 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
