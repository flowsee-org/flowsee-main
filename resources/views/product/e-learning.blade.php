@extends('layouts.site')

@section('content')
@push('styles')<link rel="stylesheet" href="{{ asset('assets/css/e-learning.css') }}?v={{ filemtime(public_path('assets/css/e-learning.css')) }}">@endpush

<a class="skip-link" href="#learning-main">رفتن به محتوای اصلی</a>
<header class="learning-topbar">
  <div class="learning-topbar-inner">
    <a class="learning-brand" href="/" aria-label="استودیو فلوسی، صفحهٔ اصلی"><span class="learning-brand-mark">F</span><span>استودیو فلوسی</span></a>
    <nav aria-label="ناوبری محصول آموزشی"><a href="#approach">رویکرد</a><a href="#services">اجزای محصول</a><a href="#process">مسیر همکاری</a><a href="#questions">پرسش‌ها</a></nav>
    <button type="button" class="learning-theme-button" data-learning-theme-toggle aria-label="فعال‌کردن حالت تاریک" title="فعال‌کردن حالت تاریک" aria-pressed="false"><svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle class="theme-icon-sun" cx="12" cy="12" r="4"/><path class="theme-icon-sun" d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/><path class="theme-icon-moon" d="M20.2 15.3A8.5 8.5 0 0 1 8.7 3.8 8.5 8.5 0 1 0 20.2 15.3Z"/></svg><span class="sr-only" data-learning-theme-label>حالت تاریک</span></button>
    <a class="learning-header-cta" href="tel:+989109027628">گفت‌وگو با فلوسی <span aria-hidden="true">↗</span></a>
  </div>
</header>

<main id="learning-main" class="learning-page">
  <section class="learning-hero" aria-labelledby="learning-title">
    <div class="container learning-hero-grid">
      <div class="learning-hero-copy">
        <span class="learning-eyebrow"><i></i> طراحی محصول آموزشی</span>
        <h1 id="learning-title">آموزشی بسازید که <em>یادگیری را به تجربه</em> تبدیل کند.</h1>
        <p>از ایدهٔ دوره تا تجربهٔ دیجیتال آن؛ مسیر یادگیری، هویت بصری، محتوا و زیرساخت را کنار هم طراحی می‌کنیم تا دانش شما ساده‌تر منتقل شود و حرفه‌ای‌تر دیده شود.</p>
        <div class="learning-hero-actions"><a class="learning-button learning-button-primary" href="tel:+989109027628">برای محصول آموزشی مشاوره بگیرید <span aria-hidden="true">↗</span></a><a class="learning-text-link" href="#approach">دیدن مسیر طراحی <span aria-hidden="true">↓</span></a></div>
        <div class="learning-proof" aria-label="ویژگی‌های همکاری با فلوسی"><span>از راهبرد تا اجرا</span><span>تجربهٔ یادگیری کاربرمحور</span><span>هماهنگ با هویت برند</span></div>
      </div>
      <div class="learning-hero-art" aria-label="نمایی انتزاعی از تجربهٔ آموزش آنلاین" role="img">
        <div class="learning-orbit learning-orbit-one"></div><div class="learning-orbit learning-orbit-two"></div>
        <div class="learning-screen"><div class="learning-screen-top"><span></span><span></span><span></span><b>مسیر یادگیری</b></div><div class="learning-screen-content"><span class="learning-screen-kicker">LEARN · PRACTICE · GROW</span><strong>دانش،<br>در مسیر عمل.</strong><div class="learning-progress"><i></i></div><small>یک تجربهٔ آموزشی منسجم</small></div></div>
        <span class="learning-art-note learning-note-top">طراحی تجربه</span><span class="learning-art-note learning-note-bottom">آموزش دیجیتال <b>↗</b></span>
      </div>
    </div>
  </section>

  <section class="container learning-intro" id="approach" aria-labelledby="approach-title">
    <div class="learning-section-label"><span>01</span><span>رویکرد فلوسی</span></div>
    <div class="learning-intro-copy"><h2 id="approach-title">دورهٔ خوب فقط مجموعه‌ای از ویدیوها نیست.</h2><p>یک محصول آموزشی موفق، هدف روشن، محتوای خوش‌ساخت و تجربه‌ای دارد که دانشجو را قدم‌به‌قدم جلو می‌برد. ما این اجزا را به یک سیستم واحد و قابل توسعه تبدیل می‌کنیم.</p></div>
    <div class="learning-stat"><strong>از ایده</strong><span>تا تجربه‌ای آمادهٔ رشد</span></div>
  </section>

  <section class="learning-services" id="services" aria-labelledby="services-title">
    <div class="container">
      <div class="learning-section-heading"><div><span class="learning-eyebrow"><i></i> اجزای محصول</span><h2 id="services-title">هر بخش، در خدمت یادگیری.</h2></div><p>نیاز محصول شما مشخص می‌کند از کجا شروع کنیم و چه چیزهایی را کنار هم بسازیم.</p></div>
      <div class="learning-service-grid">
        <article class="learning-service-card learning-card-featured"><span class="learning-card-number">۰۱</span><div class="learning-card-symbol learning-symbol-path" aria-hidden="true"><i></i><i></i><i></i></div><h3>طراحی مسیر یادگیری</h3><p>هدف آموزشی، سطح مخاطب و ترتیب محتوا را به مسیری روشن و قابل دنبال‌کردن تبدیل می‌کنیم.</p><a href="tel:+989109027628" aria-label="گفت‌وگو درباره طراحی مسیر یادگیری">گفت‌وگو دربارهٔ این بخش <span>↗</span></a></article>
        <article class="learning-service-card"><span class="learning-card-number">۰۲</span><div class="learning-card-symbol learning-symbol-brand" aria-hidden="true">F<span>+</span></div><h3>هویت بصری آموزش</h3><p>برای دوره و آکادمی شما زبانی بصری می‌سازیم که حرفه‌ای، متمایز و هماهنگ با برند باشد.</p><a href="tel:+989109027628" aria-label="گفت‌وگو درباره هویت بصری آموزش">گفت‌وگو دربارهٔ این بخش <span>↗</span></a></article>
        <article class="learning-service-card"><span class="learning-card-number">۰۳</span><div class="learning-card-symbol learning-symbol-content" aria-hidden="true"><i></i><i></i><i></i><b>▶</b></div><h3>تولید و بسته‌بندی محتوا</h3><p>ساختار درس، ویدیو و محتوای همراه را طوری آماده می‌کنیم که فهم و مرور ساده‌تر شود.</p><a href="tel:+989109027628" aria-label="گفت‌وگو درباره تولید محتوای آموزشی">گفت‌وگو دربارهٔ این بخش <span>↗</span></a></article>
        <article class="learning-service-card"><span class="learning-card-number">۰۴</span><div class="learning-card-symbol learning-symbol-digital" aria-hidden="true"><i></i><i></i><i></i><i></i></div><h3>تجربه و زیرساخت دیجیتال</h3><p>وب‌سایت، صفحهٔ معرفی و نقاط تماس را با تمرکز بر دسترسی و استفادهٔ آسان طراحی می‌کنیم.</p><a href="tel:+989109027628" aria-label="گفت‌وگو درباره تجربه دیجیتال آموزش">گفت‌وگو دربارهٔ این بخش <span>↗</span></a></article>
      </div>
    </div>
  </section>

  <section class="learning-course-showcase" aria-labelledby="course-showcase-title">
    <div class="container">
      <div class="learning-course-heading"><div><span class="learning-eyebrow"><i></i> ویترین آموزش</span><h2 id="course-showcase-title">از یادگیری تا نتیجه، یک مسیر روشن.</h2><p>یک نمونهٔ نمایشی از چیزی که می‌توان برای آکادمی یا دورهٔ شما طراحی کرد.</p></div><a class="learning-text-link" href="tel:+989109027628">طراحی آکادمی اختصاصی <span>↗</span></a></div>
      <div class="learning-course-grid">
        <article class="learning-course-card"><div class="learning-course-cover learning-cover-blue"><span>01 / DESIGN</span><b>تجربهٔ<br>کاربر</b><i>✳</i></div><div class="learning-course-info"><span>طراحی دیجیتال</span><h3>از ایده تا تجربهٔ کاربری</h3><p>ساخت یک مسیر یادگیری مرحله‌به‌مرحله</p></div></article>
        <article class="learning-course-card"><div class="learning-course-cover learning-cover-orange"><span>02 / CREATE</span><b>محتوا<br>بساز</b><i>◉</i></div><div class="learning-course-info"><span>تولید محتوا</span><h3>روایت ویدئویی برای آموزش</h3><p>ترکیب سناریو، تصویر و تمرین</p></div></article>
        <article class="learning-course-card"><div class="learning-course-cover learning-cover-violet"><span>03 / BRAND</span><b>هویت<br>آموزش</b><i>✳</i></div><div class="learning-course-info"><span>برندینگ</span><h3>ساخت هویت بصری آکادمی</h3><p>یک زبان یکپارچه برای همهٔ نقاط تماس</p></div></article>
      </div>
    </div>
  </section>

  <section class="container learning-process" id="process" aria-labelledby="process-title">
    <div class="learning-process-heading"><span class="learning-eyebrow"><i></i> مسیر همکاری</span><h2 id="process-title">شفاف، مرحله‌به‌مرحله، همراه شما.</h2><p>هر تصمیم با شناخت هدف و مخاطب شروع می‌شود و با یک محصول آمادهٔ استفاده ادامه پیدا می‌کند.</p></div>
    <ol class="learning-process-list"><li><span>۱</span><div><h3>شناخت و جهت‌دهی</h3><p>هدف آموزش، مخاطب و شرایط اجرا را روشن می‌کنیم.</p></div><b>01 / DISCOVER</b></li><li><span>۲</span><div><h3>طراحی تجربه و محتوا</h3><p>ساختار دوره، زبان بصری و مسیر استفاده را شکل می‌دهیم.</p></div><b>02 / DESIGN</b></li><li><span>۳</span><div><h3>ساخت و آماده‌سازی</h3><p>اجزای موردنیاز را تولید، پیاده‌سازی و برای انتشار آماده می‌کنیم.</p></div><b>03 / DELIVER</b></li></ol>
  </section>

  <section class="learning-cta" aria-labelledby="learning-cta-title"><div class="container learning-cta-inner"><div><span class="learning-eyebrow"><i></i> قدم بعدی</span><h2 id="learning-cta-title">دانش‌تان آمادهٔ تبدیل‌شدن به یک محصول است؟</h2><p>دربارهٔ ایده‌تان بگویید تا مسیر مناسب طراحی و اجرا را با هم پیدا کنیم.</p></div><a class="learning-button learning-button-light" href="tel:+989109027628">تماس با استودیو فلوسی <span aria-hidden="true">↗</span></a></div></section>

  <section class="container learning-faq" id="questions" aria-labelledby="questions-title"><div><span class="learning-eyebrow"><i></i> پرسش‌های رایج</span><h2 id="questions-title">قبل از شروع بدانید.</h2></div><div class="learning-faq-list"><details><summary>آیا فقط طراحی سایت آموزشی انجام می‌دهید؟<span>+</span></summary><p>خیر. بسته به نیاز پروژه می‌توانیم روی راهبرد آموزش، طراحی مسیر یادگیری، هویت بصری، تولید محتوا یا تجربهٔ دیجیتال کار کنیم.</p></details><details><summary>اگر محتوا و دوره آماده باشد، امکان همکاری هست؟<span>+</span></summary><p>بله. می‌توانیم از مرحله‌ای که اکنون در آن هستید شروع کنیم و بخش‌های لازم برای ارائهٔ حرفه‌ای‌تر دوره را طراحی کنیم.</p></details><details><summary>همکاری چطور شروع می‌شود؟<span>+</span></summary><p>با یک گفت‌وگوی اولیه دربارهٔ مخاطب، هدف آموزشی، محتوا و محدودیت‌های اجرا شروع می‌کنیم تا محدوده و اولویت‌های پروژه مشخص شود.</p></details></div></section>
</main>

<footer class="learning-footer"><div class="container"><a class="learning-brand" href="/" aria-label="استودیو فلوسی"><span class="learning-brand-mark">F</span><span>استودیو فلوسی</span></a><p>طراحی برای رشد، استراتژی برای ماندگاری.</p><a href="/">بازگشت به صفحهٔ اصلی ↗</a></div></footer>
<script>
(() => {
  const button = document.querySelector('[data-learning-theme-toggle]');
  const label = button?.querySelector('[data-learning-theme-label]');
  if (!button) return;
  const sync = () => {
    const dark = document.documentElement.dataset.theme === 'dark';
    const action = dark ? 'فعال‌کردن حالت روشن' : 'فعال‌کردن حالت تاریک';
    button.setAttribute('aria-label', action);
    button.title = action;
    button.setAttribute('aria-pressed', String(dark));
    if (label) label.textContent = dark ? 'حالت روشن' : 'حالت تاریک';
    const meta = document.querySelector('meta[name="theme-color"]');
    if (meta) meta.content = dark ? '#11151b' : '#FE5400';
  };
  sync();
  button.addEventListener('click', () => {
    const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
    document.documentElement.dataset.theme = next;
    try { localStorage.setItem('flowsee-theme', next); } catch (error) {}
    sync();
  });
})();
</script>
@endsection
