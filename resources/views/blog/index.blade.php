@extends('layouts.site')
@section('meta_title', $pageTitle)
@section('meta_description', $pageDescription)
@section('canonical_url', $pageUrl)
@section('content')
@push('styles')<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}?v={{ filemtime(public_path('assets/css/blog.css')) }}">@endpush
<a class="skip-link" href="#blog-main">رفتن به محتوای اصلی</a>
<header class="blog-topbar"><a href="/" class="blog-brand" aria-label="صفحهٔ اصلی استودیو فلوسی"><span class="blog-brand-mark">F</span><span>استودیو فلوسی</span></a><nav aria-label="ناوبری اصلی"><a href="/">خانه</a><a href="/blog" aria-current="page">بلاگ</a><a href="/#portfolio">نمونه‌کارها</a><a href="/#services">خدمات</a></nav><a class="blog-top-cta" href="/#contact-dialog">مشاوره رایگان</a></header>
<main id="blog-main" class="blog-page">
    <section class="blog-hero container">
        <div class="blog-hero-copy"><span class="blog-eyebrow"><span></span> مجلهٔ فلوسی</span><h1>{{ $category ? $category->name : 'ایده‌هایی برای برندهای رو به رشد.' }}</h1><p>{{ $category?->description ?: 'نگاه‌ها، تجربه‌ها و راهنماهای کاربردی دربارهٔ برندینگ، طراحی و رشد در دنیای دیجیتال.' }}</p><div class="blog-hero-note"><span>دانش طراحی</span><span>تجربهٔ واقعی</span><span>نگاه کاربردی</span></div></div>
        <div class="blog-hero-art" aria-hidden="true"><span class="blog-hero-orbit blog-hero-orbit-one"></span><span class="blog-hero-orbit blog-hero-orbit-two"></span><span class="blog-hero-monogram">F</span><span class="blog-hero-caption">طراحی برای رشد<br>استراتژی برای ماندگاری</span></div>
    </section>
    <section class="container blog-listing" aria-labelledby="blog-list-title">
        <div class="blog-section-heading"><div><span class="blog-eyebrow"><span></span> از دیدگاه ما</span><h2 id="blog-list-title">مقاله‌ها و راهنماها</h2></div><span class="blog-result-count">{{ $posts->total() }} مقاله</span></div>
        <nav class="blog-categories" aria-label="دسته‌بندی مقاله‌ها"><a href="{{ route('blog.index') }}" class="{{ $category ? '' : 'is-active' }}">همهٔ مقاله‌ها</a>@foreach($categories as $item)<a href="{{ route('blog.index', ['category' => $item->slug]) }}" class="{{ $category?->id === $item->id ? 'is-active' : '' }}">{{ $item->name }}</a>@endforeach</nav>
        @if($posts->count())<div class="blog-grid">@foreach($posts as $index => $post)@include('blog._card', ['post' => $post, 'featured' => $posts->currentPage() === 1 && $index === 0])@endforeach</div>
        @else<div class="blog-empty"><span class="blog-empty-mark">F</span><h3>مقاله‌ها به‌زودی منتشر می‌شوند</h3><p>به‌زودی تجربه‌ها و راهنماهای تازهٔ فلوسی را همین‌جا می‌خوانید.</p><a href="/" class="blog-button">بازگشت به صفحهٔ اصلی</a></div>@endif
        @if($posts->hasPages())<nav class="blog-pagination" aria-label="صفحه‌بندی مقاله‌ها">{{ $posts->onEachSide(1)->links('pagination::simple-default') }}</nav>@endif
    </section>
</main>
<footer class="blog-footer"><a href="/">استودیو فلوسی</a><span>طراحی برای رشد، استراتژی برای ماندگاری.</span><a href="/">صفحهٔ اصلی ↗</a></footer>
@endsection
