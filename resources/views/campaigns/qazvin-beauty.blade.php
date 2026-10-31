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
        <h1>قفسه‌ها پُر مانده‌اند؟<br><em>بگذار فروش از گوشی شروع شود.</em></h1>
        <p class="qb-hero-lead">بدون جلوی دوربین رفتن و درگیری با سایت، یک تیم محلی از ایدهٔ محتوا تا مسیر سفارش آنلاین کنار فروشگاه شماست.</p>
        <div class="qb-proof-points"><span><b>۱</b> تحلیل اختصاصی پیج</span><span><b>۲</b> سه ایدهٔ ریلز برای محصول‌های شما</span><span><b>۳</b> راه ساده‌تر برای گرفتن سفارش</span></div>
        <div class="qb-hero-actions"><a class="qb-button qb-button-primary" href="#campaign-form">دریافت تحلیل رایگان <span aria-hidden="true">←</span></a><a class="qb-link-call" href="tel:+989109027628">یا همین حالا تماس بگیرید <b dir="ltr">۰۹۱۰ ۹۰۲ ۷۶۲۸</b></a></div>
      </div>

      <div class="qb-form-card" id="campaign-form">
        <div class="qb-form-card-head"><span class="qb-form-icon" aria-hidden="true">✳</span><div><span class="qb-kicker">هدیهٔ شروع همکاری</span><h2>تحلیل رایگان پیج فروشگاه شما</h2></div></div>
        <p class="qb-form-intro">به‌همراه <strong>۳ ایدهٔ ریلز متناسب با محصولات آرایشی</strong><br><span>ارزش پیشنهادی ۲ میلیون تومان · برای فروشگاه‌های قزوین رایگان</span></p>
        <form class="qb-lead-form" data-campaign-form autocomplete="on" novalidate>
          <label>شمارهٔ تماس<input name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="۰۹۱۲ ۳۴۵ ۶۷۸۹" maxlength="24" required></label>
          <label>آیدی اینستاگرام یا نام فروشگاه<input name="store_identifier" type="text" autocomplete="organization" placeholder="مثلاً @yourshop یا نام فروشگاه" maxlength="100" required></label>
          <label class="qb-honeypot" aria-hidden="true">وب‌سایت<input name="website" tabindex="-1" autocomplete="off"></label>
          <button class="qb-button qb-button-submit" type="submit">دریافت تحلیل رایگان پیج و راهنمای فروش <span aria-hidden="true">←</span></button>
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
      <div class="qb-section-heading"><span class="qb-eyebrow"><i></i> مسیر فروش، بدون فرسودگی</span><h2 id="qb-value-title">همه‌چیز را خودتان جلو نبرید.</h2><p>زمان شما باید صرف مشتری و فروشگاه شود؛ برای حضور آنلاین، یک مسیر روشن و تیمی پاسخ‌گو داشته باشید.</p></div>
      <div class="qb-compare">
        <article class="qb-compare-card qb-old-way"><div class="qb-card-label"><span>مسیر فرسایشی</span><b>همه‌چیز روی دوش شما</b></div><ul><li>هر بار برای محتوا دنبال ایده بگردید</li><li>خودتان فیلم بگیرید و جلوی دوربین باشید</li><li>با آزمون‌وخطا هزینه کنید</li><li>سایت و سفارش‌ها را تنهایی مدیریت کنید</li></ul><div class="qb-card-foot">وقت کمتر برای رسیدگی به مشتری</div></article>
        <div class="qb-versus" aria-hidden="true">یا</div>
        <article class="qb-compare-card qb-flowsee-way"><div class="qb-card-label"><span>سیستم کلیدتحویل فلوسی</span><b>یک تیم، از ایده تا اجرا</b></div><ul><li>هویت بصری یکدست برای فروشگاه شما</li><li>سناریو و تدوین ویدیوهای مناسب شبکه‌های اجتماعی</li><li>فروشگاه آنلاین آماده و قابل مدیریت</li><li>بهینه‌سازی برای جست‌وجوی محلی قزوین</li></ul><div class="qb-card-foot">شما روی محصول و مشتری تمرکز می‌کنید <span>✓</span></div></article>
      </div>
    </div>
  </section>

  <section class="qb-offer qb-section" aria-labelledby="qb-offer-title">
    <div class="qb-wrap qb-offer-panel">
      <div class="qb-offer-copy"><span class="qb-eyebrow qb-eyebrow-light"><i></i> بدون تعهد و بدون هزینه</span><h2 id="qb-offer-title">اول مسیر را ببینید؛<br><em>بعد تصمیم بگیرید.</em></h2><p>پیج شما را بررسی می‌کنیم، فرصت‌های بهبود را نشان می‌دهیم و سه ایدهٔ قابل‌اجرا برای ریلز محصول‌های خودتان پیشنهاد می‌کنیم.</p><a class="qb-button qb-button-light" href="#campaign-form">درخواست بررسی رایگان <span aria-hidden="true">←</span></a></div>
      <div class="qb-offer-visual" aria-label="سه خروجی تحلیل رایگان" role="img"><div class="qb-orbit qb-orbit-a"></div><div class="qb-orbit qb-orbit-b"></div><div class="qb-reel-card qb-reel-one"><span>01</span><b>محصول قهرمان</b><small>نمایش چیزی که مشتری می‌خواهد ببیند</small><i>✳</i></div><div class="qb-reel-card qb-reel-two"><span>02</span><b>قبل و بعد</b><small>یک روایت کوتاه و قابل‌درک</small><i>↗</i></div><div class="qb-reel-card qb-reel-three"><span>03</span><b>پیشنهاد خرید</b><small>دعوت روشن به ثبت سفارش</small><i>+</i></div><div class="qb-offer-value">ارزش پیشنهادی <b>۲ میلیون تومان</b><small>برای فروشگاه‌های قزوین: رایگان</small></div></div>
    </div>
  </section>

  <section class="qb-work qb-section" aria-labelledby="qb-work-title">
    <div class="qb-wrap">
      <div class="qb-section-heading qb-section-heading-row"><div><span class="qb-eyebrow"><i></i> طراحی و اجرا زیر یک سقف</span><h2 id="qb-work-title">نمونه‌هایی از کار واقعی فلوسی</h2></div><p>از هویت بصری تا تجربهٔ فروشگاهی؛ توانایی تیم را در پروژه‌های اجراشده ببینید.</p></div>
      <div class="qb-work-grid">
        <a class="qb-work-card qb-work-shop" href="/projects/shopero"><img src="/assets/portfolio-imgShopero1.png" alt="طراحی تجربهٔ فروشگاهی آنلاین شاپیرو" loading="lazy" width="900" height="650"><span class="qb-work-overlay"><small>تجربهٔ فروش آنلاین</small><b>شاپیرو</b><i>دیدن پروژه ↗</i></span></a>
        <a class="qb-work-card qb-work-ima" href="/projects/ima"><img src="/assets/portfolio-imgIma2.png" alt="طراحی تجربهٔ دیجیتال ایما موویز" loading="lazy" width="900" height="650"><span class="qb-work-overlay"><small>محصول دیجیتال</small><b>ایما موویز</b><i>دیدن پروژه ↗</i></span></a>
        <a class="qb-work-card qb-work-exloot" href="/projects/exloot"><img src="/assets/portfolio-imgExloot2.png" alt="طراحی پلتفرم دیجیتال اکسلوت" loading="lazy" width="900" height="650"><span class="qb-work-overlay"><small>هویت و پلتفرم دیجیتال</small><b>اکسلوت</b><i>دیدن پروژه ↗</i></span></a>
      </div>
      <div class="qb-case-grid" aria-label="کیس‌استادی‌های مرتبط با فروشگاه و زیبایی">
        <article class="qb-case">
          <a class="qb-case-cover" href="/projects/mapi-shop"><img src="/assets/case-studies/mapi-shop/cover.jpg" alt="ماکاپ فروشگاه اینترنتی Mapi Shop" loading="lazy" width="1920" height="1080"><span>کیس‌استادی فروشگاه اینترنتی</span></a>
          <div class="qb-case-copy"><h3><a href="/projects/mapi-shop">Mapi Shop؛ تجربهٔ خرید آنلاین تخصصی</a></h3><p>طراحی صفحهٔ اصلی، دسته‌بندی و منوی فروشگاه تخصصی تجهیزات شنا. این تجربهٔ فروشگاهی می‌تواند برای محصولات آرایشی و بهداشتی نیز متناسب‌سازی شود.</p><div class="qb-case-gallery"><img src="/assets/case-studies/mapi-shop/mega-menu.jpg" alt="منوی دسته‌بندی فروشگاه Mapi Shop" loading="lazy" width="1440" height="1024"><img src="/assets/case-studies/mapi-shop/gift-modal.jpg" alt="پنجرهٔ پیشنهاد هدیه و خرید در Mapi Shop" loading="lazy" width="1440" height="1024"></div><a class="qb-case-link" href="/projects/mapi-shop">مشاهدهٔ کیس‌استادی <span aria-hidden="true">↗</span></a></div>
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
    <div class="qb-wrap"><div class="qb-section-heading"><span class="qb-eyebrow"><i></i> همکاری ساده و روشن</span><h2 id="qb-steps-title">از پیام شما تا اولین سفارش آنلاین</h2></div><ol class="qb-step-list"><li><span>۰۱</span><div><b>درخواست را ثبت کنید</b><p>شماره و آیدی یا نام فروشگاه را بفرستید.</p></div></li><li><span>۰۲</span><div><b>تحلیل و ایده‌ها را دریافت کنید</b><p>تیم فلوسی برای هماهنگی با شما تماس می‌گیرد.</p></div></li><li><span>۰۳</span><div><b>با نقشهٔ روشن تصمیم بگیرید</b><p>اگر مناسب بود، دربارهٔ مسیر اجرا و همکاری گفت‌وگو می‌کنیم.</p></div></li></ol></div>
  </section>

  <section class="qb-final qb-section" aria-labelledby="qb-final-title">
    <div class="qb-wrap qb-final-panel"><div><span class="qb-eyebrow qb-eyebrow-light"><i></i> برنامه‌ریزی محدود برای اجرای باکیفیت</span><h2 id="qb-final-title">فروشگاه بعدی که آنلاین می‌درخشد،<br><em>می‌تواند فروشگاه شما باشد.</em></h2><p>برای اینکه هر فروشگاه توجه کافی بگیرد، پذیرش این مسیر را به حداکثر ۵ فروشگاه در ماه محدود می‌کنیم. برای شروع، شماره و نام فروشگاهتان را بفرستید.</p><div class="qb-final-links"><a class="qb-whatsapp" href="https://wa.me/989109027628?text=%D8%B3%D9%84%D8%A7%D9%85%D8%8C%20%D8%A8%D8%B1%D8%A7%DB%8C%20%D8%AA%D8%AD%D9%84%DB%8C%D9%84%20%D9%BE%DB%8C%D8%AC%20%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87%20%D9%82%D8%B2%D9%88%DB%8C%D9%86%20%D9%BE%DB%8C%D8%A7%D9%85%20%D9%85%DB%8C%E2%80%8C%D8%AF%D9%87%D9%85." target="_blank" rel="noopener noreferrer">گفت‌وگو در واتس‌اپ ↗</a><a class="qb-whatsapp" href="tel:+989109027628">تماس مستقیم: ۰۹۱۰ ۹۰۲ ۷۶۲۸</a></div></div><form class="qb-lead-form qb-final-form" data-campaign-form autocomplete="on" novalidate><label>شمارهٔ تماس<input name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="۰۹۱۲ ۳۴۵ ۶۷۸۹" maxlength="24" required></label><label>آیدی اینستاگرام یا نام فروشگاه<input name="store_identifier" type="text" autocomplete="organization" placeholder="مثلاً @yourshop یا نام فروشگاه" maxlength="100" required></label><label class="qb-honeypot" aria-hidden="true">وب‌سایت<input name="website" tabindex="-1" autocomplete="off"></label><button class="qb-button qb-button-submit" type="submit">رزرو تحلیل رایگان <span aria-hidden="true">←</span></button><p class="qb-form-status" role="status" aria-live="polite"></p><p class="qb-privacy">ثبت درخواست رایگان است و تعهدی برای خرید ایجاد نمی‌کند.</p></form></div>
  </section>
</main>

<footer class="qb-footer"><div class="qb-wrap"><a class="qb-brand" href="/" aria-label="استودیو فلوسی، صفحهٔ اصلی"><img src="/assets/header-imgFrame17.svg" width="30" height="30" alt=""><span>استودیو فلوسی</span></a><p>برای فروشگاه‌های محلی که می‌خواهند آنلاین هم انتخاب شوند.</p><a href="tel:+989109027628" dir="ltr">0910 902 7628</a></div></footer>
<a class="qb-sticky-cta" href="#campaign-form">دریافت تحلیل رایگان <span aria-hidden="true">←</span></a>
@endsection
