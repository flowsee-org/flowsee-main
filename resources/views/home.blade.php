@extends('layouts.site')
@section('content')

<svg width="0" height="0" style="position:absolute;overflow:hidden" aria-hidden="true" focusable="false"><defs><symbol id="i-phone" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"></path></symbol><symbol id="i-arrow-ul" viewBox="0 0 24 24"><line x1="17" y1="17" x2="7" y2="7"></line><polyline points="7 17 7 7 17 7"></polyline></symbol><symbol id="i-arrow-down" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></symbol><symbol id="i-arrow-up" viewBox="0 0 24 24"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></symbol><symbol id="i-menu" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></symbol><symbol id="i-close" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></symbol><symbol id="i-download" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></symbol></defs></svg>
<a class="skip-link" href="#main" data-od-id="skip-navigation">رفتن به محتوای اصلی</a>
<header class="consultation-bar" id="top" data-od-id="consultation-bar"><a class="consultation-call" href="tel:+989109027628" target="_top" aria-label="تماس تلفنی برای مشاوره رایگان" data-od-id="free-consultation">مشاوره <span class="consultation-free-word">رایگان</span></a></header>
<main id="main" data-od-id="main-content">
<section class="hero container" aria-labelledby="hero-title" data-od-id="hero"><div class="hero-copy"><h1 id="hero-title" data-od-id="hero-title">طراحی برای <em>رشد،</em><br>استراتژی برای ماندگاری.</h1><p class="hero-description" data-od-id="hero-description">با ترکیب خلاقیت، طراحی و فناوری، به کسب‌وکار شما کمک می‌کنیم در دنیای دیجیتال متمایز شود.</p><div class="hero-actions"><button class="button primary" type="button" data-contact="project" data-od-id="start-project">شروع پروژه </button><a class="quiet-link" href="#portfolio" data-od-id="explore-projects">دیدن نمونه‌کارها </a></div><div class="hero-disciplines" aria-label="حوزه‌های فعالیت"><span>هویت بصری</span><span>تجربه دیجیتال</span><span>تولید محتوا</span></div></div><figure class="hero-art" data-od-id="hero-artwork"><div class="art-stage"><img src="/assets/felosi-logo-sculpture.png" alt="مجسمه لوگوی فلوسی" width="500" height="500"></div></figure></section>

<div class="container main-stack">
<section id="portfolio" aria-labelledby="portfolio-title" data-od-id="portfolio">
<div class="section-heading" data-od-id="portfolio-heading">
<div><span class="eyebrow">منتخب نمونه‌کارها</span><h2 id="portfolio-title" data-od-id="portfolio-title">طراحی را در عمل ببینید.</h2></div>
<p class="section-description">{{ $projects->count() }} پروژه، {{ $projects->count() }} تجربهٔ متفاوت از طراحی.</p>
</div>
<div class="portfolio-grid">
@foreach($projects as $project)
<button class="project-card {{ $project->is_featured ? 'featured-project' : '' }}" type="button" data-case="{{ $project->slug }}" data-od-id="project-{{ $project->slug }}" aria-label="مشاهدهٔ کیس‌استادی {{ $project->name }}">
<span class="project-visual">
<img src="{{ \App\Support\WebsiteMediaUrl::for($project->cover_image) }}" alt="{{ $project->name }}" loading="lazy">
</span>
<span class="project-meta">
<span class="project-name">{{ $project->name }}</span>
<span class="project-service">{{ $project->service?->title ?? '' }}</span>
</span>
</button>
@endforeach
</div>
</section>

<section id="services" aria-labelledby="services-title" data-od-id="services">
<div class="section-heading" data-od-id="services-heading">
<div><span class="eyebrow">خدمات ما</span><h2 id="services-title" data-od-id="services-title">از ایده تا اجرا، در کنار شما.</h2></div>
</div>
<div class="services-grid">
@foreach(App\Models\Service::where('is_active', true)->orderBy('sort_order')->get() as $service)
<article class="service-card {{ $service->is_highlighted ? 'highlighted' : '' }}" data-od-id="service-{{ $service->slug }}">
<h3>{{ $service->title }}{{ $service->description }}</h3>
</article>
@endforeach
</div>
</section>

<section class="about" id="about" aria-labelledby="about-title" data-od-id="about">
<div class="about-panel">
<img class="about-mark" src="/assets/about-flowsee-mark.svg" alt="" aria-hidden="true" loading="lazy">
<div class="about-lead"><span class="eyebrow">دربارهٔ استودیو</span><h2 id="about-title" data-od-id="about-title">فلوسی؛ همراه برند شما</h2><p>از اولین ایده تا آخرین جزئیات، کنار برند شما هستیم. هویت بصری، تجربهٔ دیجیتال و محتوا را به یک مسیر منسجم تبدیل می‌کنیم؛ مسیری که هم به‌یادماندنی است و هم به رشد واقعی کسب‌وکار کمک می‌کند.</p></div>
<ul class="about-values" aria-label="ارزش‌های استودیو"><li><span class="n" aria-hidden="true">۰۱</span><b>نوآوری</b><span>ایده‌هایی که از کلیشه فاصله می‌گیرند.</span></li><li><span class="n" aria-hidden="true">۰۲</span><b>دقت</b><span>جزئیاتی که کیفیت را می‌سازند.</span></li><li><span class="n" aria-hidden="true">۰۳</span><b>رشد</b><span>طراحی در خدمت نتیجهٔ کسب‌وکار.</span></li></ul>
</div>
</section>

<section id="articles" aria-labelledby="articles-title" data-od-id="articles">
<div class="section-heading" data-od-id="articles-heading">
<div><span class="eyebrow">یادداشت‌ها</span><h2 id="articles-title" data-od-id="articles-title">نوشته‌های تازه.</h2></div>
</div>
</section>
</div>
</main>

<footer class="site-footer" data-od-id="footer">
<div class="container footer-inner">
<a class="footer-brand" href="#top" aria-label="بازگشت به ابتدای صفحه" data-od-id="footer-brand">
<img src="/assets/footer-imgUnion.svg" alt="فلوسی" width="92" height="94">
</a>
<nav class="footer-nav" aria-label="پیوندهای پایین صفحه" data-od-id="footer-navigation">
<a href="#portfolio">نمونه‌کارها</a>
<a href="#services">خدمات</a>
<a href="#about">درباره ما</a>
<a href="#articles">یادداشت‌ها</a>
<a href="https://www.instagram.com/flowsee.ir/" target="_blank" rel="noopener">اینستاگرام</a>
</nav>
</div>
</footer>

<dialog id="contact-dialog" aria-labelledby="contact-title" data-od-id="project-dialog">
<div class="dialog-head">
<h2 id="contact-title" data-od-id="contact-title">شروع پروژه</h2>
<button type="button" class="close-dialog" data-close aria-label="بستن" data-od-id="close-project-dialog"><svg class="icon" aria-hidden="true"><use href="#i-close"></use></svg></button>
</div>
<div id="contact-form-content">
<p class="dialog-note">پس از ارسال، اطلاعات پروژه برای پیگیری در پایگاه دادهٔ فلوسی ثبت می‌شود.</p>
<form id="brief-form" class="form-grid" data-od-id="project-form" autocomplete="off" novalidate>
<label>نام شما <span class="required-marker" aria-hidden="true">*</span><span class="sr-only">(الزامی)</span>
<input name="name" required maxlength="100" data-od-id="brief-name" id="brief-name" aria-describedby="error-name">
<span class="field-error" id="error-name" hidden aria-live="polite"></span>
</label>
<label>شمارهٔ تماس <span class="required-marker" aria-hidden="true">*</span><span class="sr-only">(الزامی)</span>
<input type="tel" name="phone" inputmode="tel" dir="ltr" required minlength="7" maxlength="24" aria-describedby="phone-hint error-phone" data-od-id="brief-phone" id="brief-phone">
<span id="phone-hint" class="field-hint">شماره‌ای که بتوانیم با شما تماس بگیریم.</span>
<span class="field-error" id="error-phone" hidden aria-live="polite"></span>
</label>
<label>ایمیل (اختیاری)
<input type="email" name="email" dir="ltr" data-od-id="brief-email" id="brief-email" aria-describedby="error-email">
<span class="field-error" id="error-email" hidden aria-live="polite"></span>
</label>
<label>خدمت موردنظر
<select name="service" data-od-id="brief-service" aria-label="انتخاب خدمت" id="brief-service" aria-describedby="error-service">
@foreach(App\Models\Service::where('is_active', true)->orderBy('sort_order')->get() as $service)
<option value="{{ $service->slug }}">{{ $service->title }} {{ $service->description }}</option>
@endforeach
</select>
</label>
<label>درباره پروژه
<textarea name="details" rows="4" maxlength="5000" placeholder="پروژهٔ خود را توضیح دهید..." data-od-id="brief-details" aria-describedby="error-details"></textarea>
<span class="field-error" id="error-details" hidden aria-live="polite"></span>
</label>
<button class="button primary" type="submit" data-od-id="submit-project">ارسال درخواست</button>
<p id="form-status" class="form-status" role="status" aria-live="polite"></p>
<p class="sr-only" id="form-success-message">پیام شما با موفقیت ارسال شد</p>
</form>
</div>
</dialog>

<dialog id="preview-dialog" class="preview-dialog" aria-labelledby="preview-title" data-od-id="project-preview">
<div class="project-window-bar" data-od-id="preview-toolbar"><span>منتخب پروژه‌های فلوسی</span><button class="close-dialog" type="button" data-close aria-label="بستن پروژه" data-od-id="close-preview"><svg class="icon" aria-hidden="true"><use href="#i-close"></use></svg></button></div>
<div class="preview-scroll" data-od-id="preview-scroll">
  <header class="project-intro" data-od-id="preview-intro"><div><span class="eyebrow">طراحی و تجربهٔ دیجیتال</span><h2 id="preview-title" dir="rtl" data-od-id="preview-title"></h2></div><p id="preview-description" data-od-id="preview-description"></p></header>
  <figure class="project-showcase" data-od-id="preview-artwork"><div id="preview-image"></div></figure>
  <div class="project-window-bottom" data-od-id="preview-bottom"><p>از ایدهٔ شما شروع کنیم.</p><button class="button primary" type="button" data-contact="project" data-od-id="preview-start-project">گفت‌وگو دربارهٔ پروژه</button></div>
</div>
<nav class="project-pagination" aria-label="مرور پروژه‌ها" data-od-id="preview-navigation"><button type="button" id="preview-prev" data-od-id="preview-previous">پروژهٔ قبلی</button><span id="preview-position" aria-live="polite" aria-atomic="true"></span><button type="button" id="preview-next" data-od-id="preview-next">پروژهٔ بعدی</button></nav>
</dialog>

<dialog id="case-dialog" class="case-dialog" aria-labelledby="case-dialog-title" data-od-id="case-dialog">
<div class="case-bar">
<span class="case-bar-title" id="case-dialog-title" data-od-id="case-dialog-title"></span>
<button class="close-dialog" type="button" data-close aria-label="بستن" data-od-id="close-case-dialog"><svg class="icon" aria-hidden="true"><use href="#i-close"></use></svg></button>
</div>
<div class="case-scroll" data-od-id="case-scroll">
<article class="case-study" id="case-content">
<header class="cs-hero container" data-od-id="case-hero">
<div class="case-intro-copy">
<span class="eyebrow" id="case-eyebrow"></span>
<h2 class="cs-title" data-od-id="case-title" id="case-title"></h2>
<p class="cs-lead" id="case-lead"></p>
</div>
<ul class="meta" aria-label="مشخصات پروژه">
<li><span class="k">کارفرما</span><span class="v" id="case-client"></span></li>
<li><span class="k">حوزه</span><span class="v" id="case-industry"></span></li>
<li><span class="k">خدمات</span><span class="v" id="case-services"></span></li>
</ul>
</header>
<div id="case-body"></div>
<div class="container"><div class="cs-cta"><div><span class="eyebrow">قدم بعدی</span><h3>پروژهٔ بعدی شما، یک هویت ماندگار.</h3><p>از تحلیل بریف تا توسعهٔ هویت بصری، در کنار شما هستیم.</p></div><div class="cs-actions"><button class="button primary" type="button" data-contact="project" data-od-id="case-start-project">شروع پروژه <svg class="icon" aria-hidden="true"><use href="#i-arrow-ul"></use></svg></button><a class="quiet-link" href="tel:+989109027628" data-od-id="case-phone">۰۹۱۰۹۰۲۷۶۲۸ <svg class="icon" aria-hidden="true"><use href="#i-phone"></use></svg></a></div></div></div>
</article>
</div>
</dialog>

<dialog id="lightbox" class="lightbox" aria-labelledby="lightbox-cap" data-od-id="lightbox">
<div class="dialog-head"><h2 id="lightbox-cap"></h2><button class="close-dialog" type="button" data-close aria-label="بستن تصویر" data-od-id="close-lightbox"><svg class="icon" aria-hidden="true"><use href="#i-close"></use></svg></button></div>
<div class="lightbox-tools">
<div class="gallery-nav" aria-label="جابه‌جایی بین تصاویر"><button type="button" class="gallery-button" id="gallery-prev" data-od-id="gallery-previous">قبلی</button><span id="gallery-count" class="gallery-count" aria-live="polite" aria-atomic="true"></span><button type="button" class="gallery-button" id="gallery-next" data-od-id="gallery-next">بعدی</button></div>
<button class="zoom-toggle" id="zoom-toggle" type="button" aria-pressed="false" data-od-id="image-zoom-toggle">اندازهٔ واقعی</button>
</div>
<p id="gallery-status" class="gallery-status" role="status" aria-live="polite" hidden></p>
<div class="lightbox-viewport" id="lightbox-viewport" tabindex="0" aria-label="تصویر بزرگ‌شده؛ برای حرکت از کلیدهای جهت استفاده کنید" data-od-id="image-zoom-viewport"><img id="lightbox-img" alt=""></div>
</dialog>

<script>
window.projectsData = {!! $projectsData !!};
</script>

<script src="{{ asset('assets/js/site.js') }}?v={{ filemtime(public_path('assets/js/site.js')) }}" defer></script>

@endsection
