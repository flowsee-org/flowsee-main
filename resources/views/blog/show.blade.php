@extends('layouts.site')
@section('meta_title', $pageTitle)
@section('meta_description', $pageDescription)
@section('canonical_url', $pageUrl)
@section('meta_image', $imageUrl)
@section('content')
@push('styles')<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?v={{ filemtime(public_path('assets/css/blog.css')) }}">@endpush
<a class="skip-link" href="#article-main">رفتن به محتوای اصلی</a>
<header class="blog-topbar"><a href="/" class="blog-brand" aria-label="صفحهٔ اصلی استودیو فلوسی"><span class="blog-brand-mark">F</span><span>استودیو فلوسی</span></a><nav aria-label="ناوبری اصلی"><a href="/">خانه</a><a href="/blog" aria-current="page">بلاگ</a><a href="/#portfolio">نمونه‌کارها</a><a href="/#services">خدمات</a></nav><a class="blog-top-cta" href="/#contact-dialog">مشاوره رایگان</a></header>
<main id="article-main" class="blog-article-page">
    <div class="container article-shell">
        <nav class="article-breadcrumb" aria-label="مسیر صفحه"><a href="/">خانه</a><span>/</span><a href="{{ route('blog.index') }}">بلاگ</a><span>/</span><a href="{{ route('blog.index', ['category' => $post->category->slug]) }}">{{ $post->category->name }}</a></nav>
        <article>
            <header class="article-header"><span class="blog-eyebrow"><span></span>{{ $post->category->name }}</span><h1>{{ $post->title }}</h1>@if($post->excerpt)<p class="article-lead">{{ $post->excerpt }}</p>@endif<div class="article-byline"><span>استودیو فلوسی</span><time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('j F Y') }}</time></div></header>
            @if($post->cover_image)<figure class="article-cover"><img src="{{ $imageUrl }}" alt="{{ $post->cover_alt ?: $post->title }}" fetchpriority="high"><figcaption>{{ $post->cover_alt ?: $post->title }}</figcaption></figure>@endif
            <div class="article-layout"><aside class="article-aside"><span>در این مقاله</span><a href="#article-content">{{ $post->title }}</a><a href="{{ route('blog.index', ['category' => $post->category->slug]) }}">مقاله‌های {{ $post->category->name }}</a></aside><div id="article-content" class="article-content">{!! $post->content !!}</div></div>
        </article>
    </div>
    @if($relatedPosts->isNotEmpty())<section class="container related-posts"><div class="blog-section-heading"><div><span class="blog-eyebrow"><span></span> ادامهٔ خواندن</span><h2>از همین دسته</h2></div><a class="blog-text-link" href="{{ route('blog.index', ['category' => $post->category->slug]) }}">همهٔ مقاله‌ها ↗</a></div><div class="blog-grid related-grid">@foreach($relatedPosts as $related)@include('blog._card', ['post' => $related, 'featured' => false])@endforeach</div></section>@endif
</main>
<footer class="blog-footer"><a href="/">استودیو فلوسی</a><span>طراحی برای رشد، استراتژی برای ماندگاری.</span><a href="{{ route('blog.index') }}">همهٔ مقاله‌ها ↗</a></footer>
@endsection
