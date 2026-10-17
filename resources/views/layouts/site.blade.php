<!DOCTYPE html><html lang="fa" dir="rtl"><head>
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
<meta name="description" content="{{ $__env->yieldContent('meta_description', $pageDescription ?? 'Flowsee (استودیو فلوسی)؛ استودیوی طراحی برند و تجربهٔ دیجیتال. طراحی هویت بصری، بازاریابی دیجیتال و توسعهٔ نرم‌افزار.') }}">
<link rel="canonical" href="{{ $__env->yieldContent('canonical_url', $pageUrl ?? 'https://flowsee.ir/') }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="fa_IR">
<meta property="og:site_name" content="استودیو فلوسی | Flowsee">
<meta property="og:url" content="{{ $__env->yieldContent('canonical_url', $pageUrl ?? 'https://flowsee.ir/') }}">
<meta property="og:title" content="{{ $__env->yieldContent('meta_title', $pageTitle ?? 'استودیو فلوسی (Flowsee) | طراحی برند و تجربهٔ دیجیتال') }}">
<meta property="og:description" content="{{ $__env->yieldContent('meta_description', $pageDescription ?? 'Flowsee (استودیو فلوسی)؛ استودیوی طراحی برند و تجربهٔ دیجیتال. طراحی هویت بصری، بازاریابی دیجیتال و توسعهٔ نرم‌افزار.') }}">
<meta property="og:image" content="{{ $__env->yieldContent('meta_image', $imageUrl ?? 'https://flowsee.ir/assets/flowsee-social.jpg') }}">
<meta property="og:image:secure_url" content="{{ $__env->yieldContent('meta_image', $imageUrl ?? 'https://flowsee.ir/assets/flowsee-social.jpg') }}">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="استودیو فلوسی؛ طراحی برای رشد و ماندگاری">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $__env->yieldContent('meta_title', $pageTitle ?? 'استودیو فلوسی (Flowsee) | طراحی برند و تجربهٔ دیجیتال') }}">
<meta name="twitter:description" content="{{ $__env->yieldContent('meta_description', $pageDescription ?? 'Flowsee (استودیو فلوسی)؛ استودیوی طراحی برند و تجربهٔ دیجیتال. طراحی هویت بصری، بازاریابی دیجیتال و توسعهٔ نرم‌افزار.') }}">
<meta name="twitter:image" content="{{ $__env->yieldContent('meta_image', $imageUrl ?? 'https://flowsee.ir/assets/flowsee-social.jpg') }}">
<meta name="theme-color" content="#FE5400"><title>{{ $__env->yieldContent('meta_title', $pageTitle ?? 'استودیو فلوسی (Flowsee) | طراحی برند و تجربهٔ دیجیتال') }}</title>
<script>
try {
  const savedTheme = localStorage.getItem('flowsee-theme');
  const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  document.documentElement.dataset.theme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
} catch (error) {
  document.documentElement.dataset.theme = 'light';
}
</script>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="preload" as="image" href="/assets/felosi-logo-sculpture.png" fetchpriority="high">





<link rel="preload" href="{{ asset('assets/css/site.css') }}?v={{ filemtime(public_path('assets/css/site.css')) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="{{ asset('assets/css/mobile.css') }}?v={{ filemtime(public_path('assets/css/mobile.css')) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ asset('assets/css/site.css') }}"><link rel="stylesheet" href="{{ asset('assets/css/mobile.css') }}"></noscript>
@stack('styles')
<script type="application/ld+json">@json($structuredData)</script>
</head>

<body>
@yield('content')
<script defer src="{{ asset('assets/js/site.js') }}?v={{ filemtime(public_path('assets/js/site.js')) }}"></script>
</body></html>
