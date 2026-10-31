@extends('layouts.campaign')

@section('content')
<a class="qb-skip" href="#main">رفتن به محتوای اصلی</a>
<header class="qb-header">
  <div class="qb-header-inner">
    <a class="qb-brand" href="/" aria-label="استودیو فلوسی، صفحهٔ اصلی"><img src="/assets/header-imgFrame17.svg" width="36" height="36" alt=""><span>استودیو فلوسی</span></a>
    <span class="qb-local"><i></i> همراه فروشگاه‌های قزوین</span>
    <a class="qb-header-call" href="tel:+989109027628" aria-label="تماس با فلوسی"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 11.2 18.8a19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.13 4.2 2 2 0 0 1 4.12 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.1 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg><span>تماس مستقیم</span></a>
  </div>
</header>

<main id="main">
  <section class="qb-hero">
    <div class="qb-hero-glow" aria-hidden="true"></div>
    <div class="qb-wrap qb-hero-grid">
      <div class="qb-hero-copy">
        <span class="qb-eyebrow"><i></i> ویژهٔ فروشگاه‌های آرایشی و بهداشتی قزوین</span>
        <h1>محصولات آرایشی‌تان<br><em>یک فروشگاه آنلاین درخور می‌خواهند.</em></h1>
        <p class="qb-hero-lead">برای فروشگاه‌های آرایشی و بهداشتی قزوین، سایت فروشگاهی می‌سازیم تا مشتری محصول را پیدا کند، جزئیات را ببیند و سفارش خود را آنلاین ثبت کند؛ با همراهی یک تیم محلی.</p>
        <div class="qb-proof-points"><span><b>۱</b> دسته‌بندی و جست‌وجوی روشن محصولات</span><span><b>۲</b> صفحهٔ محصول با عکس، قیمت و مشخصات</span><span><b>۳</b> مسیر سادهٔ سبد خرید و ثبت سفارش</span></div>
        <div class="qb-hero-actions"><a class="qb-button qb-button-primary" href="#campaign-form">دریافت نقشهٔ رایگان فروشگاه <span aria-hidden="true">←</span></a><a class="qb-link-call" href="tel:+989109027628">یا همین حالا تماس بگیرید <b dir="ltr">۰۹۱۰ ۹۰۲ ۷۶۲۸</b></a></div>
      </div>

      <div class="qb-form-card" id="campaign-form">
        <div class="qb-form-card-head"><span class="qb-form-icon" aria-hidden="true">✳</span><div><span class="qb-kicker">هدیهٔ شروع همکاری</span><h2>نقشهٔ اولیهٔ فروشگاه آنلاین شما</h2></div></div>
        <p class="qb-form-intro">یک بررسی رایگان از <strong>نیازهای سایت فروشگاهی شما</strong><br><span>از معرفی و دسته‌بندی کالا تا مسیر ثبت سفارش</span></p>
        <form class="qb-lead-form" data-campaign-form autocomplete="on" novalidate>
          <label>شمارهٔ تماس<input name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="۰۹۱۲ ۳۴۵ ۶۷۸۹" maxlength="24" required></label>
          <label>نام فروشگاه یا آیدی اینستاگرام<input name="store_identifier" type="text" autocomplete="organization" placeholder="مثلاً نام فروشگاه یا @yourshop" maxlength="100" required></label>
          <label class="qb-honeypot" aria-hidden="true">وب‌سایت<input name="website" tabindex="-1" autocomplete="off"></label>
          <button class="qb-button qb-button-submit" type="submit">دریافت نقشهٔ رایگان فروشگاه اینترنتی <span aria-hidden="true">←</span></button>
          <p class="qb-form-status" role="status" aria-live="polite"></p>
          <p class="qb-privacy">اطلاعات شما فقط برای تماس دربارهٔ همین درخواست استفاده می‌شود.</p>
        </form>
        <div class="qb-card-stamp" aria-hidden="true"><span>ویژه</span><b>قزوین</b></div>
      </div>
      <div class="qb-hero-note"><span>فروشگاه محلی شما</span><b>در رقابت آنلاین تنها نیست.</b><i aria-hidden="true">↗</i></div>
    </div>
  </section>

  <section class="qb-value qb-section" aria-labelledby="qb-value-title">
    <div class="qb-wrap">
      <div class="qb-section-heading"><span class="qb-eyebrow"><i></i> فروش آنلاین برای فروشگاه‌های زیبایی</span><h2 id="qb-value-title">از پیج شلوغ، به فروشگاهی مرتب و همیشه در دسترس.</h2><p>مشتری باید بتواند بین محصولات آرایشی و بهداشتی بگردد، انتخاب کند و سفارش بدهد؛ حتی وقتی شما مشغول رسیدگی به فروشگاه هستید.</p></div>
      <div class="qb-compare">
        <article class="qb-compare-card qb-old-way"><div class="qb-card-label"><span>فروش فقط از راه پیج</span><b>سفارش‌ها پراکنده و وابسته به پیام‌ها</b></div><ul><li>مشتری برای پیدا کردن هر محصول باید بپرسد</li><li>موجودی و مشخصات کالا در پیام‌ها گم می‌شود</li><li>ثبت و پیگیری سفارش‌ها دستی انجام می‌شود</li><li>در جست‌وجوی گوگل، فروشگاه شما پیدا نمی‌شود</li></ul><div class="qb-card-foot">خرید سخت‌تر و زمان بیشتر برای پاسخ‌گویی</div></article>
        <div class="qb-versus" aria-hidden="true">یا</div>
        <article class="qb-compare-card qb-flowsee-way"><div class="qb-card-label"><span>فروشگاه اینترنتی با فلوسی</span><b>محصول تا سفارش، در یک مسیر روشن</b></div><ul><li>دسته‌بندی، جست‌وجو و فیلتر متناسب با کالاهای شما</li><li>صفحهٔ محصول با تصویر، قیمت، مشخصات و موجودی</li><li>سبد خرید و مسیر ثبت سفارش سازگار با موبایل</li><li>ساختار آماده برای معرفی فروشگاه در جست‌وجوی محلی قزوین</li></ul><div class="qb-card-foot">یک سایت قابل مدیریت برای فروش روزانه <span>✓</span></div></article>
      </div>
    </div>
  </section>

  <section class="qb-offer qb-section" aria-labelledby="qb-offer-title">
    <div class="qb-wrap qb-offer-panel">
      <div class="qb-offer-copy"><span class="qb-eyebrow qb-eyebrow-light"><i></i> مشاورهٔ شروع، رایگان و بدون تعهد</span><h2 id="qb-offer-title">قبل از ساخت سایت،<br><em>نقشهٔ فروشگاهتان را ببینید.</em></h2><p>با هم مشخص می‌کنیم مشتری‌ها چطور محصولاتتان را پیدا کنند، چه اطلاعاتی برای خرید لازم دارند و مسیر ثبت سفارش سایت از کجا شروع شود.</p><a class="qb-button qb-button-light" href="#campaign-form">درخواست نقشهٔ رایگان <span aria-hidden="true">←</span></a></div>
      <div class="qb-offer-visual" aria-label="سه بخش اصلی فروشگاه اینترنتی: دسته‌بندی، صفحه محصول و ثبت سفارش" role="img"><div class="qb-orbit qb-orbit-a"></div><div class="qb-orbit qb-orbit-b"></div><div class="qb-reel-card qb-reel-one"><span>01</span><b>دسته‌بندی کالا</b><small>پیدا کردن آسان محصولات</small><i>✳</i></div><div class="qb-reel-card qb-reel-two"><span>02</span><b>صفحهٔ محصول</b><small>عکس، قیمت و مشخصات روشن</small><i>↗</i></div><div class="qb-reel-card qb-reel-three"><span>03</span><b>ثبت سفارش</b><small>خرید ساده با موبایل</small><i>+</i></div><div class="qb-offer-value">فروشگاه اینترنتی <b>ویژهٔ محصولات زیبایی</b><small>متناسب با فروشگاه شما</small></div></div>
    </div>
  </section>

  <section class="qb-work qb-section" aria-labelledby="qb-work-title">
    <div class="qb-wrap">
      <div class="qb-section-heading qb-section-heading-row"><div><span class="qb-eyebrow"><i></i> تجربهٔ طراحی فروشگاه آنلاین</span><h2 id="qb-work-title">ساختار یک فروشگاه اینترنتی را از نزدیک ببینید.</h2></div><p>در پروژهٔ Mapi Shop، مسیر صفحهٔ اصلی، دسته‌بندی و انتخاب کالا را برای فروشگاه تخصصی طراحی کردیم؛ همین منطق برای محصولات آرایشی و بهداشتی قزوین متناسب‌سازی می‌شود.</p></div>
      <div class="qb-work-grid">
        <a class="qb-work-card qb-work-shop" href="#mapi-case"><img src="/assets/case-studies/mapi-shop/cover.jpg" alt="طراحی فروشگاه اینترنتی تخصصی Mapi Shop" loading="lazy" width="1920" height="1080"><span class="qb-work-overlay"><small>طراحی فروشگاه اینترنتی تخصصی</small><b>Mapi Shop</b><i>دیدن کیس‌استادی ↗</i></span></a>
        <a class="qb-work-card qb-work-ima" href="/projects/shopero"><img src="/assets/portfolio-imgShopero1.png" alt="طراحی تجربهٔ فروشگاه آنلاین شاپیرو" loading="lazy" width="900" height="650"><span class="qb-work-overlay"><small>تجربهٔ خرید آنلاین</small><b>شاپیرو</b><i>دیدن پروژه ↗</i></span></a>
      </div>
      <div class="qb-case-grid" aria-label="کیس‌استادی‌های مرتبط با فروشگاه و زیبایی">
        <article class="qb-case" id="mapi-case">
          <a class="qb-case-cover" href="#mapi-case"><img src="/assets/case-studies/mapi-shop/cover.jpg" alt="ماکاپ فروشگاه اینترنتی Mapi Shop" loading="lazy" width="1920" height="1080"><span>کیس‌استادی فروشگاه اینترنتی</span></a>
          <div class="qb-case-copy"><h3><a href="#mapi-case">Mapi Shop؛ تجربهٔ خرید آنلاین تخصصی</a></h3><p>برای Mapi Shop، فروشگاه تخصصی لوازم شنا، صفحهٔ اصلی، دسته‌بندی‌های چندسطحی و منوی مگا طراحی شد. این نمونه نشان می‌دهد چطور محصولات متنوع را منظم نمایش دهیم و مسیر رسیدن مشتری از دسته‌بندی تا خرید را کوتاه کنیم؛ الگویی قابل‌سفارشی‌سازی برای فروشگاه‌های آرایشی و بهداشتی.</p><div class="qb-case-gallery"><img src="/assets/case-studies/mapi-shop/mega-menu.jpg" alt="منوی دسته‌بندی فروشگاه Mapi Shop" loading="lazy" width="1440" height="1024"><img src="/assets/case-studies/mapi-shop/gift-modal.jpg" alt="پنجرهٔ پیشنهاد هدیه و خرید در Mapi Shop" loading="lazy" width="1440" height="1024"></div><a class="qb-case-link" href="#mapi-case">مشاهدهٔ کیس‌استادی <span aria-hidden="true">↗</span></a></div>
        </article>
        <article class="qb-case qb-case-hadis">
          <a class="qb-case-cover" href="/projects/hadisnailline"><img src="/assets/case-studies/hadisnailline/flyer.jpg" alt="ماکاپ تراکت معرفی خدمات Hadisnailline" loading="lazy" width="2200" height="1760"><span>کیس‌استادی هویت چاپی</span></a>
          <div class="qb-case-copy"><h3><a href="/projects/hadisnailline">Hadisnailline؛ از معرفی خدمات تا رزرو</a></h3><p>مجموعه‌ای هماهنگ از تراکت و کارت ویزیت برای معرفی خدمات ناخن، راه ارتباطی و دسترسی سریع به صفحهٔ اینستاگرام.</p><div class="qb-case-gallery"><img src="/assets/case-studies/hadisnailline/business-card.jpg" alt="ماکاپ کارت ویزیت Hadisnailline با QR کد" loading="lazy" width="2200" height="1467"><img src="/assets/case-studies/hadisnailline/flyer.jpg" alt="جزئیات تراکت خدمات Hadisnailline" loading="lazy" width="2200" height="1760"></div><a class="qb-case-link" href="/projects/hadisnailline">مشاهدهٔ کیس‌استادی <span aria-hidden="true">↗</span></a></div>
        </article>
      </div>
      <div class="qb-local-note"><span class="qb-local-symbol">Q</span><p><b>تیم محلی در قزوین</b><br>برای جلسه، عکاسی یا فیلم‌برداری حضوری محصولات، می‌توانیم نزدیک فروشگاه شما باشیم.</p><a href="https://maps.app.goo.gl/kN2kZ9AkS6nGbnoC7" target="_blank" rel="noopener">موقعیت استودیو <span aria-hidden="true">↗</span></a></div>
    </div>
  </section>

  <section class="qb-steps qb-section" aria-labelledby="qb-steps-title">
    <div class="qb-wrap"><div class="qb-section-heading"><span class="qb-eyebrow"><i></i> از نیاز فروشگاه تا سایت آمادهٔ سفارش</span><h2 id="qb-steps-title">مراحل طراحی فروشگاه اینترنتی شما</h2></div><ol class="qb-step-list"><li><span>۰۱</span><div><b>نیازها و کالاها را می‌شناسیم</b><p>دسته‌بندی محصولات، روش مدیریت و مسیر خرید مشتری را مشخص می‌کنیم.</p></div></li><li><span>۰۲</span><div><b>ساختار و ظاهر فروشگاه را طراحی می‌کنیم</b><p>صفحهٔ اصلی، فهرست کالاها و جزئیات محصول را برای موبایل و دسکتاپ می‌چینیم.</p></div></li><li><span>۰۳</span><div><b>مسیر ثبت سفارش را آماده می‌کنیم</b><p>سبد خرید و ثبت سفارش را بررسی می‌کنیم تا مشتری راحت‌تر خریدش را کامل کند.</p></div></li></ol></div>
  </section>

  <section class="qb-final qb-section" aria-labelledby="qb-final-title">
    <div class="qb-wrap qb-final-panel"><div><span class="qb-eyebrow qb-eyebrow-light"><i></i> گفت‌وگوی اولیه دربارهٔ فروشگاه اینترنتی</span><h2 id="qb-final-title">محصولاتتان را آنلاین هم<br><em>راحت و مرتب بفروشید.</em></h2><p>برای طراحی فروشگاه اینترنتی ویژهٔ محصولات آرایشی و بهداشتی در قزوین، نام فروشگاه و شمارهٔ تماس را بفرستید تا دربارهٔ نیازها و مراحل اجرا صحبت کنیم.</p><div class="qb-final-links"><a class="qb-whatsapp" href="https://wa.me/989109027628?text=%D8%B3%D9%84%D8%A7%D9%85%D8%8C%20%D8%A8%D8%B1%D8%A7%DB%8C%20%D8%B7%D8%B1%D8%A7%D8%AD%DB%8C%20%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87%20%D8%A7%DB%8C%D9%86%D8%AA%D8%B1%D9%86%D8%AA%DB%8C%20%D9%85%D8%AD%D8%B5%D9%88%D9%84%D8%A7%D8%AA%20%D8%A2%D8%B1%D8%A7%DB%8C%D8%B4%DB%8C%20%D8%AF%D8%B1%20%D9%82%D8%B2%D9%88%DB%8C%D9%86%20%D9%BE%DB%8C%D8%A7%D9%85%20%D9%85%DB%8C%E2%80%8C%D8%AF%D9%87%D9%85." target="_blank" rel="noopener noreferrer">گفت‌وگو در واتس‌اپ ↗</a><a class="qb-whatsapp" href="tel:+989109027628">تماس مستقیم: ۰۹۱۰ ۹۰۲ ۷۶۲۸</a></div></div><form class="qb-lead-form qb-final-form" data-campaign-form autocomplete="on" novalidate><label>شمارهٔ تماس<input name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="۰۹۱۲ ۳۴۵ ۶۷۸۹" maxlength="24" required></label><label>نام فروشگاه یا آیدی اینستاگرام<input name="store_identifier" type="text" autocomplete="organization" placeholder="مثلاً نام فروشگاه یا @yourshop" maxlength="100" required></label><label class="qb-honeypot" aria-hidden="true">وب‌سایت<input name="website" tabindex="-1" autocomplete="off"></label><button class="qb-button qb-button-submit" type="submit">درخواست مشاورهٔ طراحی سایت <span aria-hidden="true">←</span></button><p class="qb-form-status" role="status" aria-live="polite"></p><p class="qb-privacy">ثبت درخواست رایگان است و تعهدی برای خرید ایجاد نمی‌کند.</p></form></div>
  </section>
</main>

<footer class="qb-footer"><div class="qb-wrap"><a class="qb-brand" href="/" aria-label="استودیو فلوسی، صفحهٔ اصلی"><img src="/assets/header-imgFrame17.svg" width="30" height="30" alt=""><span>استودیو فلوسی</span></a><p>برای فروشگاه‌های محلی که می‌خواهند آنلاین هم انتخاب شوند.</p><a href="tel:+989109027628" dir="ltr">0910 902 7628</a></div></footer>
@endsection
