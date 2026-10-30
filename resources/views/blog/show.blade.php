@extends('layouts.site')
@section('meta_title', $pageTitle)
@section('meta_description', $pageDescription)
@section('canonical_url', $pageUrl)
@section('meta_image', $imageUrl)
@section('content')
@push('styles')<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?v={{ filemtime(public_path('assets/css/blog.css')) }}">@endpush
<a class="skip-link" href="#article-main">رفتن به محتوای اصلی</a>
<header class="blog-topbar"><a href="/" class="blog-brand" aria-label="صفحهٔ اصلی استودیو فلوسی"><span class="blog-brand-mark">F</span><span>استودیو فلوسی</span></a><nav aria-label="ناوبری اصلی"><a href="/">خانه</a><a href="/blog" aria-current="page">بلاگ</a><a href="/#portfolio">نمونه‌کارها</a><a href="/#services">خدمات</a></nav><div class="blog-header-actions"><button type="button" class="blog-theme-toggle" data-theme-toggle aria-label="فعال‌کردن حالت تاریک" title="فعال‌کردن حالت تاریک" aria-pressed="false"><svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle class="theme-icon-sun" cx="12" cy="12" r="4"/><path class="theme-icon-sun" d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/><path class="theme-icon-moon" d="M20.2 15.3A8.5 8.5 0 0 1 8.7 3.8 8.5 8.5 0 1 0 20.2 15.3Z"/></svg><span class="sr-only" data-theme-label>حالت تاریک</span></button><a class="blog-top-cta" href="/#contact-dialog">مشاوره رایگان</a></div></header>
<main id="article-main" class="blog-article-page">
    <div class="container article-shell">
        <nav class="article-breadcrumb" aria-label="مسیر صفحه"><a href="/">خانه</a><span aria-hidden="true">/</span><a href="{{ route('blog.index') }}">بلاگ</a><span aria-hidden="true">/</span><a href="{{ route('blog.index', ['category' => $post->category->slug]) }}">{{ $post->category->name }}</a></nav>
        <article>
            <header class="article-header">
                <span class="blog-eyebrow"><span></span>{{ $post->category->name }}</span>
                <h1>{{ $post->title }}</h1>
                @if($post->excerpt)<p class="article-lead">{{ $post->excerpt }}</p>@endif
                <div class="article-byline"><span class="article-author-mark" aria-hidden="true">F</span><span>استودیو فلوسی</span><i aria-hidden="true"></i><time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('j F Y') }}</time><i aria-hidden="true"></i><span>{{ $readingMinutes }} دقیقه مطالعه</span></div>
            </header>
            @if($post->cover_image)<figure class="article-cover"><img src="{{ $imageUrl }}" alt="{{ $post->cover_alt ?: $post->title }}" fetchpriority="high"><figcaption><span>{{ $post->cover_alt ?: $post->title }}</span><a href="{{ route('blog.index', ['category' => $post->category->slug]) }}">{{ $post->category->name }} <span aria-hidden="true">↗</span></a></figcaption></figure>@endif
            <div class="article-layout">
                <aside class="article-aside" aria-label="راهنمای مقاله"><div class="article-aside-title"><span class="article-aside-icon" aria-hidden="true">☰</span><span>در این مقاله</span></div><nav class="article-toc" aria-label="سرفصل‌های مقاله"><a class="is-active" href="#article-content">شروع مقاله</a>@foreach($postHeadings as $heading)<a data-level="{{ $heading['level'] }}" href="#{{ $heading['id'] }}">{{ $heading['text'] }}</a>@endforeach</nav><a class="article-category-link" href="{{ route('blog.index', ['category' => $post->category->slug]) }}"><span>مطالب بیشتر در</span><strong>{{ $post->category->name }}</strong><span aria-hidden="true">↗</span></a></aside>
                <div id="article-content" class="article-content">{!! $post->content !!}</div>
            </div>
        </article>
    </div>
    @if($relatedPosts->isNotEmpty())<section class="container related-posts"><div class="blog-section-heading"><div><span class="blog-eyebrow"><span></span> ادامهٔ خواندن</span><h2>از همین دسته</h2></div><a class="blog-text-link" href="{{ route('blog.index', ['category' => $post->category->slug]) }}">همهٔ مقاله‌ها ↗</a></div><div class="blog-grid related-grid">@foreach($relatedPosts as $related)@include('blog._card', ['post' => $related, 'featured' => false])@endforeach</div></section>@endif
</main>
<footer class="blog-footer"><a href="/">استودیو فلوسی</a><span>طراحی برای رشد، استراتژی برای ماندگاری.</span><a href="{{ route('blog.index') }}">همهٔ مقاله‌ها ↗</a></footer>
@endsection
