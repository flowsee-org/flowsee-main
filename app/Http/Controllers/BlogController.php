<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Support\WebsiteMediaUrl;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /** Public listing data for the server-rendered Next.js blog. Never expose drafts or article bodies. */
    public function feed(Request $request)
    {
        $request->validate(['page' => ['sometimes', 'integer', 'min:1'], 'category' => ['sometimes', 'nullable', 'string', 'max:255']]);
        $categories = BlogCategory::query()->orderBy('sort_order')->get(['id', 'name', 'slug', 'description']);
        $slug = $request->query('category');
        $category = $slug ? $categories->firstWhere('slug', $slug) : null;
        abort_if($slug && ! $category, 404);

        $posts = BlogPost::query()->with('category:id,name,slug')
            ->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now())
            ->when($category, fn ($query) => $query->where('blog_category_id', $category->id))
            ->orderByDesc('is_featured')->orderByDesc('published_at')->orderByDesc('id')->paginate(9);

        $stories = BlogPost::query()->with('category:id,name,slug')
            ->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now())
            ->when($category, fn ($query) => $query->where('blog_category_id', $category->id));
        $serialize = fn ($items) => $items->map(fn ($post) => [
            'id' => $post->id, 'title' => $post->title, 'slug' => $post->slug,
            'excerpt' => $post->excerpt, 'coverUrl' => $post->cover_image ? WebsiteMediaUrl::for($post->cover_image) : null,
            'coverAlt' => $post->cover_alt ?: $post->title, 'category' => $post->category,
            'publishedAt' => $post->published_at->toIso8601String(),
        ])->values();
        return response()->json([
            'featured' => $serialize((clone $stories)->where('is_featured', true)->latest('published_at')->limit(4)->get()),
            'latest' => $serialize((clone $stories)->latest('published_at')->orderByDesc('id')->limit(4)->get()),
            'popular' => $serialize((clone $stories)->where('views', '>', 0)->orderByDesc('views')->latest('published_at')->limit(5)->get()),
            'categories' => $categories,
            'category' => $category,
            'posts' => $posts->getCollection()->map(fn (BlogPost $post) => [
                'id' => $post->id, 'title' => $post->title, 'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'coverUrl' => $post->cover_image ? WebsiteMediaUrl::for($post->cover_image) : null,
                'coverAlt' => $post->cover_alt ?: $post->title,
                'publishedAt' => $post->published_at->toIso8601String(),
                'category' => $post->category,
            ])->values(),
            'pagination' => ['currentPage' => $posts->currentPage(), 'lastPage' => $posts->lastPage(), 'total' => $posts->total(), 'perPage' => $posts->perPage()],
        ], 200, ['Cache-Control' => 'no-cache']);
    }

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

        // Count page requests, not unique people. Do not invent a popularity ranking before visits exist.
        $post->increment('views');

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
        $readingMinutes = max(1, (int) ceil(preg_match_all('/[\pL\pN]+/u', strip_tags($post->content)) / 180));
        $postHeadings = collect();
        $content = preg_replace_callback('/<h([2-3])([^>]*)>(.*?)<\/h[2-3]>/is', function ($matches) use ($post, $postHeadings) {
            $text = trim(strip_tags($matches[3]));
            $id = trim((string) preg_replace('/[^\\pL\\pN]+/u', '-', mb_strtolower($text)), '-');
            $id = $id !== '' ? $id : 'section-'.$postHeadings->count();
            $id = 'article-'.$post->id.'-'.$id;
            $postHeadings->push(['id' => $id, 'text' => $text, 'level' => (int) $matches[1]]);
            $attributes = preg_replace('/\\s+id\\s*=\\s*(["\\']).*?\\1/i', '', $matches[2]);
            return '<h'.$matches[1].$attributes.' id="'.$id.'">'.$matches[3].'</h'.$matches[1].'>';
        }, $post->content);
        $post->content = $content ?? $post->content;
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

        return view('blog.show', compact('post', 'relatedPosts', 'postHeadings', 'readingMinutes', 'pageTitle', 'pageDescription', 'pageUrl', 'imageUrl', 'structuredData'));
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
