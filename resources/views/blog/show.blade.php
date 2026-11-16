@extends('layouts.site')
@section('meta_title', $pageTitle)
@section('meta_description', $pageDescription)
@section('canonical_url', $pageUrl)
@section('meta_image', $imageUrl)
@section('og_type', 'article')
@if($isStackArticle)
@section('alternate_links')
<link rel="alternate" hreflang="fa" href="{{ route('blog.show', $post->slug) }}">
<link rel="alternate" hreflang="en" href="{{ route('stack-guides.show.en', $post->slug) }}">
<link rel="alternate" hreflang="x-default" href="{{ route('blog.show', $post->slug) }}">
@endsection
@endif
@section('content')
@push('styles')<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?v={{ filemtime(public_path('assets/css/blog.css')) }}">@endpush
@php
    $homeUrl = $isEnglish ? '/en' : '/';
    $technologyUrl = $isEnglish ? '/en#technology-stacks' : route('blog.index', ['category' => $post->category->slug]);
@endphp
<a class="skip-link" href="#article-main">{{ $articleUi['skip'] }}</a>
<header class="blog-topbar">
    <a href="{{ $homeUrl }}" class="blog-brand" aria-label="{{ $articleUi['brand'] }}"><span class="blog-brand-mark">F</span><span>{{ $articleUi['brand'] }}</span></a>
    <nav aria-label="{{ $articleUi['blog'] }}"><a href="{{ $homeUrl }}">{{ $articleUi['home'] }}</a><a href="{{ $technologyUrl }}" aria-current="page">{{ $articleUi['blog'] }}</a><a href="{{ $homeUrl }}#portfolio">{{ $articleUi['portfolio'] }}</a><a href="{{ $homeUrl }}#services">{{ $articleUi['services'] }}</a></nav>
    <div class="blog-header-actions"><button type="button" class="blog-theme-toggle" data-theme-toggle aria-label="{{ $articleUi['theme_dark'] }}" title="{{ $articleUi['theme_dark'] }}" aria-pressed="false"><svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle class="theme-icon-sun" cx="12" cy="12" r="4"/><path class="theme-icon-sun" d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/><path class="theme-icon-moon" d="M20.2 15.3A8.5 8.5 0 0 1 8.7 3.8 8.5 8.5 0 1 0 20.2 15.3Z"/></svg><span class="sr-only" data-theme-label>{{ $articleUi['theme_dark'] }}</span></button><a class="blog-top-cta" href="{{ $homeUrl }}#contact-dialog">{{ $articleUi['consultation'] }}</a></div>
</header>
<main id="article-main" class="blog-article-page" lang="{{ $isEnglish ? 'en' : 'fa' }}" dir="{{ $isEnglish ? 'ltr' : 'rtl' }}">
    <div class="container article-shell">
        <nav class="article-breadcrumb" aria-label="{{ $articleUi['breadcrumb'] }}"><a href="{{ $homeUrl }}">{{ $articleUi['home'] }}</a><span aria-hidden="true">/</span><a href="{{ $technologyUrl }}">{{ $articleUi['blog'] }}</a><span aria-hidden="true">/</span><span>{{ $isEnglish ? 'Development technologies' : $post->category->name }}</span></nav>
        <article>
            <header class="article-header">
                <span class="blog-eyebrow"><span></span>{{ $isEnglish ? 'Development technologies' : $post->category->name }}</span>
                <h1>{{ $post->title }}</h1>
                @if($post->excerpt)<p class="article-lead">{{ $post->excerpt }}</p>@endif
                <div class="article-byline"><span class="article-author-mark" aria-hidden="true">F</span><span>{{ $articleUi['author'] }}</span><i aria-hidden="true"></i><time datetime="{{ $post->published_at->toDateString() }}">{{ $isEnglish ? $post->published_at->format('F j, Y') : $post->published_at->translatedFormat('j F Y') }}</time><i aria-hidden="true"></i><span>{{ $readingMinutes }} {{ $articleUi['reading_minutes'] }}</span></div>
            </header>
            @if($post->cover_image)<figure class="article-cover"><img src="{{ $imageUrl }}" alt="{{ $post->cover_alt ?: $post->title }}" fetchpriority="high"><figcaption><span>{{ $post->cover_alt ?: $post->title }}</span><a href="{{ $technologyUrl }}">{{ $isEnglish ? 'Development technologies' : $post->category->name }} <span aria-hidden="true">↗</span></a></figcaption></figure>@endif
            <div class="article-layout">
                <aside class="article-aside" aria-label="{{ $articleUi['contents'] }}"><div class="article-aside-title"><span class="article-aside-icon" aria-hidden="true">☰</span><span>{{ $articleUi['contents'] }}</span></div><nav class="article-toc" aria-label="{{ $articleUi['contents'] }}"><a class="is-active" href="#article-content">{{ $articleUi['start'] }}</a>@foreach($postHeadings as $heading)<a data-level="{{ $heading['level'] }}" href="#{{ $heading['id'] }}">{{ $heading['text'] }}</a>@endforeach</nav><a class="article-category-link" href="{{ $technologyUrl }}"><span>{{ $articleUi['more_in'] }}</span><strong>{{ $isEnglish ? 'Development technologies' : $post->category->name }}</strong><span aria-hidden="true">↗</span></a></aside>
                <div id="article-content" class="article-content">{!! $post->content !!}</div>
            </div>
        </article>
    </div>
    @if($relatedPosts->isNotEmpty())<section class="container related-posts"><div class="blog-section-heading"><div><span class="blog-eyebrow"><span></span>{{ $articleUi['continue_reading'] }}</span><h2>{{ $articleUi['same_category'] }}</h2></div><a class="blog-text-link" href="{{ $technologyUrl }}">{{ $articleUi['all_articles'] }} ↗</a></div><div class="blog-grid related-grid">@foreach($relatedPosts as $related)@include('blog._card', ['post' => $related, 'featured' => false])@endforeach</div></section>@endif
</main>
<footer class="blog-footer"><a href="{{ $homeUrl }}">{{ $articleUi['brand'] }}</a><span>{{ $articleUi['footer_tagline'] }}</span><a href="{{ $technologyUrl }}">{{ $articleUi['all_articles'] }} ↗</a></footer>
@endsection
