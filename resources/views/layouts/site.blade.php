<!DOCTYPE html><html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="google-site-verification" content="UAQcvYOs7dLeVV987bTILlMz0EU8I0LTdyOlBlKpfeA">
<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "ywjxxggyxf");
</script>
<meta name="robots" content="index,follow,max-image-preview:large">
<meta name="description" content="{!! e($__env->yieldContent('meta_description', $pageDescription ?? 'Flowsee (استودیو فلوسی)؛ استودیوی طراحی برند و تجربهٔ دیجیتال. طراحی هویت بصری، بازاریابی دیجیتال و توسعهٔ نرم‌افزار.'), false) !!}">
<link rel="canonical" href="{!! e($__env->yieldContent('canonical_url', $pageUrl ?? 'https://flowsee.ir/'), false) !!}">
@php
    $hasTranslation = request()->routeIs('home', 'home.en');
    $faPath = '';
    $enPath = 'en';
@endphp
@if($hasTranslation)
<link rel="alternate" hreflang="fa" href="{{ url($faPath) }}">
<link rel="alternate" hreflang="en" href="{{ url($enPath) }}">
<link rel="alternate" hreflang="x-default" href="{{ url($faPath) }}">
@endif
@yield('alternate_links')
<meta property="og:type" content="{!! e($__env->yieldContent('og_type', 'website'), false) !!}">
<meta property="og:locale" content="{{ app()->getLocale() === 'en' ? 'en_US' : 'fa_IR' }}">
<meta property="og:site_name" content="استودیو فلوسی | Flowsee">
<meta property="og:url" content="{!! e($__env->yieldContent('canonical_url', $pageUrl ?? 'https://flowsee.ir/'), false) !!}">
<meta property="og:title" content="{!! e($__env->yieldContent('meta_title', $pageTitle ?? 'استودیو فلوسی (Flowsee) | طراحی برند و تجربهٔ دیجیتال'), false) !!}">
<meta property="og:description" content="{!! e($__env->yieldContent('meta_description', $pageDescription ?? 'Flowsee (استودیو فلوسی)؛ استودیوی طراحی برند و تجربهٔ دیجیتال. طراحی هویت بصری، بازاریابی دیجیتال و توسعهٔ نرم‌افزار.'), false) !!}">
<meta property="og:image" content="{!! e($__env->yieldContent('meta_image', $imageUrl ?? 'https://flowsee.ir/assets/flowsee-social.jpg'), false) !!}">
<meta property="og:image:secure_url" content="{!! e($__env->yieldContent('meta_image', $imageUrl ?? 'https://flowsee.ir/assets/flowsee-social.jpg'), false) !!}">
@unless(isset($imageUrl))
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
@endunless
<meta property="og:image:alt" content="{{ $post->cover_alt ?? $pageTitle ?? 'استودیو فلوسی؛ طراحی برای رشد و ماندگاری' }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{!! e($__env->yieldContent('meta_title', $pageTitle ?? 'استودیو فلوسی (Flowsee) | طراحی برند و تجربهٔ دیجیتال'), false) !!}">
<meta name="twitter:description" content="{!! e($__env->yieldContent('meta_description', $pageDescription ?? 'Flowsee (استودیو فلوسی)؛ استودیوی طراحی برند و تجربهٔ دیجیتال. طراحی هویت بصری، بازاریابی دیجیتال و توسعهٔ نرم‌افزار.'), false) !!}">
<meta name="twitter:image" content="{!! e($__env->yieldContent('meta_image', $imageUrl ?? 'https://flowsee.ir/assets/flowsee-social.jpg'), false) !!}">
<meta name="theme-color" content="#FE5400"><title>{!! e($__env->yieldContent('meta_title', $pageTitle ?? 'استودیو فلوسی (Flowsee) | طراحی برند و تجربهٔ دیجیتال'), false) !!}</title>
<script>
try {
  const savedTheme = localStorage.getItem('flowsee-theme');
  document.documentElement.dataset.theme = savedTheme || 'light';
} catch (error) {
  document.documentElement.dataset.theme = 'light';
}
</script>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
@if(request()->routeIs('home', 'home.en'))
<link rel="preload" as="image" type="image/webp" href="/assets/felosi-logo-sculpture-640.webp" imagesrcset="/assets/felosi-logo-sculpture-640.webp 640w, /assets/felosi-logo-sculpture-960.webp 960w" imagesizes="(max-width: 649px) 300px, (max-width: 899px) 280px, 500px" fetchpriority="high">
@endif
<link rel="preload" as="font" type="font/woff2" href="/assets/fonts/IRANSansX-Regular.woff2" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="/assets/fonts/IRANSansXFaNum-Regular.woff2" crossorigin>





<link rel="preload" href="{{ asset('assets/css/site.css') }}?v={{ filemtime(public_path('assets/css/site.css')) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="{{ asset('assets/css/mobile.css') }}?v={{ filemtime(public_path('assets/css/mobile.css')) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ asset('assets/css/site.css') }}"><link rel="stylesheet" href="{{ asset('assets/css/mobile.css') }}"></noscript>
@stack('styles')
<script type="application/ld+json">@json($structuredData)</script>
</head>

<body>
@php
    $isEnglish = app()->getLocale() === 'en';
    $isStackArticle = $isStackArticle ?? false;
    $faPath = $isStackArticle ? route('blog.show', $post->slug) : '';
    $enPath = $isStackArticle ? route('stack-guides.show.en', $post->slug) : 'en';
@endphp
@unless(request()->routeIs('home', 'home.en', 'blog.show', 'stack-guides.show.en', 'blog.show.en') || $isStackArticle)
<nav class="language-switcher" aria-label="{{ $isEnglish ? 'Language' : 'زبان' }}">
  <a href="{{ url($isEnglish ? $faPath : $enPath) }}" lang="{{ $isEnglish ? 'fa' : 'en' }}">{{ $isEnglish ? __('ui.language_fa') : __('ui.language') }}</a>
</nav>
@endunless
@yield('content')
@if(app()->getLocale() === 'en')<script>window.flowseeTranslations = @json(\Illuminate\Support\Facades\Lang::get('client'));</script>@endif
@unless(request()->routeIs('product.e-learning'))<script defer src="{{ asset('assets/js/site.js') }}?v={{ filemtime(public_path('assets/js/site.js')) }}"></script>@endunless
</body></html>
