<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#fffaf6">
  <meta name="description" content="{{ $pageDescription }}">
  <link rel="canonical" href="https://flowsee.ir/qazvin-beauty">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="fa_IR">
  <meta property="og:site_name" content="استودیو فلوسی">
  <meta property="og:title" content="{{ $pageTitle }}">
  <meta property="og:description" content="{{ $pageDescription }}">
  <meta property="og:image" content="https://flowsee.ir/assets/flowsee-social.jpg">
  <title>{{ $pageTitle }}</title>
  <link rel="icon" href="/favicon.svg" type="image/svg+xml">
  <link rel="preload" href="/assets/fonts/IRANSansX-Regular.ttf" as="font" type="font/ttf" crossorigin>
  <link rel="preload" href="/assets/fonts/IRANSansX-Medium.ttf" as="font" type="font/ttf" crossorigin>
  <link rel="stylesheet" href="{{ asset('assets/css/qazvin-beauty.css') }}?v={{ filemtime(public_path('assets/css/qazvin-beauty.css')) }}">
  <script type="application/ld+json">@json([
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'تحلیل رایگان بازاریابی فروشگاه آرایشی در قزوین',
    'serviceType' => 'تحلیل شبکه‌های اجتماعی و مشاورهٔ فروش محلی',
    'provider' => ['@type' => 'Organization', 'name' => 'استودیو فلوسی', 'url' => 'https://flowsee.ir/'],
    'areaServed' => ['@type' => 'City', 'name' => 'قزوین'],
    'url' => 'https://flowsee.ir/qazvin-beauty',
    'description' => $pageDescription,
  ])</script>
</head>
<body>
  @yield('content')
  <script defer src="{{ asset('assets/js/qazvin-beauty.js') }}?v={{ filemtime(public_path('assets/js/qazvin-beauty.js')) }}"></script>
</body>
</html>
