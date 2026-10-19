@extends('layouts.site')
@section('meta_title', $pageTitle)
@section('meta_description', $pageDescription)
@section('canonical_url', $pageUrl)
@section('content')
@push('styles')<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?v={{ filemtime(public_path('assets/css/blog.css')) }}">@endpush
<a class="skip-link" href="#blog-main">رفتن به محتوای اصلی</a>
<header class="blog-topbar"><a href="/" class="blog-brand" aria-label="صفحهٔ اصلی استودیو فلوسی"><span class="blog-brand-mark">F</span><span>استودیو فلوسی</span></a><nav aria-label="ناوبری اصلی"><a href="/">خانه</a><a href="/blog" aria-current="page">بلاگ</a><a href="/#portfolio">نمونه‌کارها</a><a href="/#services">خدمات</a></nav><a class="blog-top-cta" href="/#contact-dialog">مشاوره رایگان</a></header>
<main id="blog-main" class="blog-page">
    <section class="container blog-listing" aria-labelledby="blog-list-title">
        <div class="blog-section-heading"><div><span class="blog-eyebrow"><span></span> از دیدگاه ما</span><h1 id="blog-list-title">{{ $category?->name ?: "مجلهٔ فلوسی" }}</h1></div><span class="blog-result-count">{{ $posts->total() }} مقاله</span></div>
        <nav class="blog-categories" aria-label="دسته‌بندی مقاله‌ها"><a href="{{ route('blog.index') }}" class="{{ $category ? '' : 'is-active' }}">همهٔ مقاله‌ها</a>@foreach($categories as $item)<a href="{{ route('blog.index', ['category' => $item->slug]) }}" class="{{ $category?->id === $item->id ? 'is-active' : '' }}">{{ $item->name }}</a>@endforeach</nav>
        @if($posts->count())<div class="blog-bento">@foreach($posts as $index => $post)@include('blog._card', ['post' => $post, 'featured' => $index === 0 || $index === 3, 'bento' => true])@endforeach</div>
        @else<div class="blog-empty"><span class="blog-empty-mark">F</span><h3>مقاله‌ها به‌زودی منتشر می‌شوند</h3><p>به‌زودی تجربه‌ها و راهنماهای تازهٔ فلوسی را همین‌جا می‌خوانید.</p><a href="/" class="blog-button">بازگشت به صفحهٔ اصلی</a></div>@endif
        @if($posts->count())<section class="blog-latest" aria-labelledby="latest-title"><div class="blog-section-heading"><h2 id="latest-title">تازه‌ترین مقاله‌ها</h2></div><div class="blog-latest-grid">@foreach($posts->getCollection()->sortByDesc('published_at') as $post)@include('blog._card', ['post' => $post, 'featured' => false, 'bento' => false])@endforeach</div></section>@endif
        @if($posts->hasPages())<nav class="blog-pagination" aria-label="صفحه‌بندی مقاله‌ها">{{ $posts->onEachSide(1)->links('pagination::simple-default') }}</nav>@endif
    </section>
</main>
<footer class="blog-footer"><a href="/">استودیو فلوسی</a><span>طراحی برای رشد، استراتژی برای ماندگاری.</span><a href="/">صفحهٔ اصلی ↗</a></footer>
@endsection
