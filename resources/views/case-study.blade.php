@verbatim
<!DOCTYPE html><html lang="fa" dir="rtl"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="کیس‌استادی ابراهیمی — طراحی لوگو و هویت بصری برای مرکز تخصصی بازسازی، تیون ظاهری و نصب آپشن خودرو؛ پروژهٔ استودیو فلوسی.">
<meta name="theme-color" content="#012233"><title>کیس‌استادی ابراهیمی — طراحی لوگو و هویت بصری | استودیو فلوسی</title>
<link rel="icon" href="/assets/header-imgFrame17.svg" type="image/svg+xml">
<style>
@font-face{font-family:IRANSansX;src:url('assets/fonts/IRANSansX-Regular.ttf') format('truetype');font-weight:400;font-display:swap}
@font-face{font-family:IRANSansX;src:url('assets/fonts/IRANSansX-Medium.ttf') format('truetype');font-weight:500 900;font-display:swap}
@font-face{font-family:IRANSansXFaNum;src:url('assets/fonts/IRANSansXFaNum-Regular.ttf') format('truetype');font-weight:400;font-display:swap}
@font-face{font-family:PARADOX;src:url('assets/fonts/PARADOX-Regular.ttf') format('truetype');font-weight:400;font-display:swap}
@font-face{font-family:Montserrat;src:url('assets/fonts/Montserrat-Regular.ttf') format('truetype');font-weight:400;font-display:swap}
:root{
  --bg: oklch(100.0000% 0 0);
  --surface: oklch(96.1151% 0 0);
  --fg: oklch(21.7787% 0 0);
  --muted: oklch(42.0237% 0 0);
  --border: oklch(92.4940% 0 0);
  --accent: oklch(67.3204% 0.21731 38.649);
  --blue: oklch(44.1127% 0.06906 233.606);
  --blue-deep: oklch(33.8445% 0.05014 231.981);
  --blue-light: oklch(85.1015% 0.04397 231.036);
  --blue-pale: oklch(92.6769% 0.02113 227.535);
  --display:PARADOX,IRANSansX,sans-serif;--body:IRANSansXFaNum,IRANSansX,sans-serif;--latin:Montserrat,sans-serif;
  --content:1120px;--space:24px;--radius:16px;--focus:var(--blue);
  --brand-navy:#012233;--brand-blue:#4140C0;--brand-yellow:#FFBE00;
}
*{box-sizing:border-box}
html{scroll-behavior:smooth;scroll-padding-top:112px}
body{margin:0;background:var(--bg);color:var(--fg);font-family:var(--body);font-size:16px;line-height:1.85}
button,input,textarea,select{font:inherit}button{cursor:pointer;border:0;color:inherit}a{color:inherit;text-decoration:none}button:disabled{cursor:default}
a,button,input,textarea,select{-webkit-tap-highlight-color:transparent;touch-action:manipulation}
:focus-visible{outline:3px solid var(--focus);outline-offset:5px}
img{display:block;max-width:100%;height:auto}
h1,h2,h3,p{margin:0}
.container{width:min(var(--content),calc(100% - 64px));margin-inline:auto}
.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip-path:inset(50%);white-space:nowrap}
.skip-link{position:fixed;top:8px;right:16px;padding:10px 20px;background:var(--fg);color:var(--bg);z-index:20;transform:translateY(-160%)}
.skip-link:focus{transform:none}
.eyebrow{display:block;color:var(--muted);font:400 13px/1.8 var(--body);margin-bottom:12px}

/* buttons: solid action is white-on-black (as requested) */
.button{min-height:50px;padding:12px 24px;font:500 15px/1.7 IRANSansX,sans-serif;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;gap:14px;border:1px solid transparent;transition:background .2s,color .2s,border-color .2s,transform .2s}
.solid{background:var(--fg);color:var(--bg)}
.solid:hover{background:oklch(from var(--fg) calc(l + .1) c h);color:var(--bg);transform:translateY(-2px)}
.outline{background:transparent;border-color:var(--border);color:var(--fg)}
.outline:hover{border-color:var(--fg);background:oklch(from var(--fg) l c h / .05);color:var(--fg);transform:translateY(-2px)}
.consult{background:var(--fg);color:var(--bg);gap:11px;padding:7px 15px;min-height:52px}
.consult:hover{background:oklch(from var(--fg) calc(l + .1) c h);color:var(--bg)}
.consult .ico-phone{display:grid;place-items:center;width:34px;height:34px;border-radius:50%;background:oklch(from var(--bg) l c h / .14);flex-shrink:0}
.consult-text{display:flex;flex-direction:column;line-height:1.4;text-align:right}
.consult-label{font:500 12px/1.4 IRANSansX,sans-serif}
.consult-num{font:400 13px/1.4 Montserrat,IRANSansX,sans-serif;letter-spacing:.02em}

/* header */
.site-header{position:sticky;top:0;z-index:10;border-bottom:1px solid var(--border);background:oklch(from var(--bg) l c h / .94);backdrop-filter:blur(16px)}
.header-inner{height:88px;display:flex;gap:40px;align-items:center;justify-content:space-between}
.brand{display:flex;align-items:center;gap:12px;flex-shrink:0}
.brand img{width:44px;height:auto}.brand>span{font:400 22px/1.6 var(--display)}
.nav{display:flex;align-items:center;gap:28px;margin-inline:auto}
.nav a{position:relative;display:flex;align-items:center;min-height:48px;padding:6px 0;color:var(--muted);font-size:14px}
.nav a:hover,.nav a[aria-current]{color:var(--fg)}
.nav a[aria-current]::after{content:'';position:absolute;bottom:2px;right:0;left:0;height:2px;background:var(--fg)}
.header-actions{flex-shrink:0}.header-actions .consult{font-size:13px}
.menu-toggle{display:none;background:transparent;color:var(--fg);width:44px;height:44px;font-size:24px;border-radius:8px}
.menu-toggle:hover{background:var(--surface)}

/* hero */
.case-hero{padding-block:44px 40px}
.breadcrumb{display:flex;gap:10px;align-items:center;font-size:13px;color:var(--muted);margin-bottom:26px}
.breadcrumb a{display:inline-flex;align-items:center;min-height:44px}.breadcrumb a:hover{color:var(--fg);text-decoration:underline;text-underline-offset:5px}
.case-hero h1{font:400 clamp(44px,6vw,78px)/1.4 var(--display);letter-spacing:-1px}
.case-hero .hero-lead{max-width:640px;margin-top:20px;color:var(--muted);font-size:18px;line-height:2;text-wrap:balance}
.meta{list-style:none;display:flex;flex-wrap:wrap;gap:12px 40px;margin:30px 0 0;padding:0}
.meta li{display:grid;gap:2px}
.meta dt,.meta .meta-k{font-size:12px;color:var(--muted)}
.meta .meta-v{font:400 17px/1.6 var(--display)}
.hero-actions{display:flex;flex-wrap:wrap;align-items:center;gap:16px 22px;margin-top:34px}

/* cover */
.cover{position:relative;border-block:1px solid var(--border);background:var(--brand-navy)}
.cover img{width:100%;height:auto}
.cover figcaption{margin:0;padding:14px 0;text-align:center;color:var(--blue-pale);font-size:12px;border-top:1px solid oklch(from var(--blue-light) l c h / .28)}

/* section rhythm */
.case-flow{display:flex;flex-direction:column;gap:0}
.case-section{padding-block:0 0}
.case-section .inner{padding-block:52px}
.band{display:block;width:100%;margin:0;padding:0;border:0;border-block:1px solid var(--border);background:var(--brand-navy);overflow:hidden;cursor:zoom-in}
.band img{width:100%;height:clamp(150px,16vw,220px);object-fit:cover;object-position:center}
.sec-head{max-width:780px;display:grid;gap:12px;margin-bottom:34px}
.sec-head h2{font:400 clamp(28px,3.2vw,42px)/1.65 var(--display);text-wrap:balance}
.sec-head .sec-lead{color:var(--muted);font-size:16px;line-height:2.05;max-width:660px;text-wrap:pretty}
.sec-head .index{color:var(--accent)}

/* overview trio + steps */
.trio{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:32px}
.trio article{padding-top:22px;border-top:2px solid var(--fg);display:grid;gap:10px}
.trio h3{font:400 21px/1.6 var(--display)}
.trio p{color:var(--muted);font-size:14px;line-height:2;text-wrap:pretty}
.steps{list-style:none;margin:56px 0 0;padding:0;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:28px}
.steps li{display:grid;gap:8px}
.steps .step-n{font:400 30px/1 var(--display);color:var(--accent)}
.steps h3{font:400 18px/1.6 var(--display)}
.steps p{color:var(--muted);font-size:13px;line-height:1.95;text-wrap:pretty}

/* figures + grids */
.fig{display:block;width:100%;padding:0;border:1px solid var(--border);border-radius:14px;overflow:hidden;background:var(--surface);cursor:zoom-in;transition:border-color .2s,box-shadow .2s}
.fig:hover{border-color:var(--blue);box-shadow:0 12px 30px oklch(from var(--fg) l c h / .08)}
.fig img{width:100%;height:auto}
.fig-grid{display:grid;gap:20px}
.g2{grid-template-columns:repeat(2,minmax(0,1fr))}
.g3{grid-template-columns:repeat(3,minmax(0,1fr))}
.wide{grid-column:1/-1}
.fig-cap{display:block;margin-top:10px;color:var(--muted);font-size:12.5px;line-height:1.9;padding-inline:2px}

/* palette */
.palette{list-style:none;display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:16px;margin:0 0 40px;padding:0}
.palette li{display:grid;gap:10px}
.palette .sw{display:block;height:104px;border-radius:12px;background:var(--sw);border:1px solid oklch(from var(--fg) l c h / .12)}
.palette .sw-meta{display:grid;gap:2px}
.palette b{font:400 14px/1.5 var(--display);font-weight:400}
.palette code{font:400 12px/1.5 Montserrat,monospace;color:var(--muted);direction:ltr;text-align:right}

/* closing */
.closing-cover{border-block:1px solid var(--border);background:var(--brand-navy)}
.closing-cover img{width:100%;height:clamp(240px,34vw,540px);object-fit:cover;object-position:center}
.cta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:32px;align-items:center;padding-block:56px}
.cta h2{font:400 clamp(30px,3.6vw,46px)/1.6 var(--display);text-wrap:balance}
.cta p{color:var(--muted);margin-top:14px;font-size:16px}
.cta-actions{display:flex;flex-wrap:wrap;gap:16px 20px;align-items:center}

/* footer */
.site-footer{margin-top:24px;background:var(--blue-deep);color:var(--bg)}
.footer-bottom{display:flex;justify-content:space-between;align-items:center;gap:28px;padding-block:32px}
.footer-brand{display:flex;align-items:center;gap:14px}
.footer-brand img{width:40px;height:auto}.footer-brand span{font:400 22px/1.6 var(--display)}
.footer-nav{display:flex;gap:26px;align-items:center;flex-wrap:wrap}
.footer-nav a{display:flex;align-items:center;min-height:44px;font-size:13px;color:var(--blue-pale)}
.footer-nav a:hover{color:var(--bg);text-decoration:underline;text-underline-offset:5px}
.site-footer :focus-visible{outline-color:var(--blue-light)}

/* dialogs */
dialog{width:min(660px,calc(100% - 32px));max-height:calc(100dvh - 40px);border:1px solid var(--border);border-radius:20px;padding:32px;background:var(--bg);color:var(--fg);box-shadow:0 24px 80px oklch(0% 0 0/.25)}
dialog::backdrop{background:oklch(10% .01 240/.62);backdrop-filter:blur(5px)}
.dialog-head{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px}
.dialog-head h2{font-size:30px;line-height:1.6}
.close-dialog{width:44px;height:44px;border-radius:50%;background:var(--surface);color:var(--fg);font:28px/1 sans-serif;flex:0 0 44px}
.close-dialog:hover{background:var(--border)}
.dialog-note{font-size:15px;color:var(--muted);margin-bottom:20px}
.form-grid{display:grid;gap:16px}
.form-grid label{display:grid;gap:6px;font-size:15px}
.form-grid input,.form-grid textarea,.form-grid select{width:100%;min-width:0;min-height:48px;border:1px solid var(--border);border-radius:8px;background:var(--bg);color:var(--fg);padding:10px 12px;font-size:16px}
.form-grid textarea{resize:vertical;min-height:110px}
.form-grid .button{justify-self:start;margin-top:4px}
.form-status{font-size:14px;color:var(--blue-deep);min-height:25px}
.lightbox{width:min(1280px,calc(100% - 28px));padding:18px}
.lightbox img{max-height:80dvh;width:auto;max-width:100%;margin:auto;border-radius:10px}
.lightbox .dialog-head{margin-bottom:12px}
.lightbox h2{font:400 15px/1.6 var(--body);color:var(--muted)}

@media(max-width:1099px){
  .brand>span{font-size:20px}.nav{gap:22px}.case-hero h1{font-size:clamp(42px,5.4vw,60px)}
  .trio{gap:24px}.palette{grid-template-columns:repeat(3,minmax(0,1fr))}
}
@media(max-width:899px){
  .container{width:calc(100% - 48px)}
  .header-inner{height:76px;gap:18px}.header-actions{margin-inline-start:auto}.brand>span{font-size:21px}
  .menu-toggle{display:grid;place-items:center}
  .nav{display:none;position:absolute;top:calc(100% + 8px);right:24px;left:24px;margin:0;padding:12px;border:1px solid var(--border);border-radius:12px;background:var(--bg);box-shadow:0 12px 28px oklch(from var(--fg) l c h / .1);gap:4px}
  .nav.open{display:grid;grid-template-columns:1fr 1fr}
  .nav a{font-size:15px;justify-content:center;padding:12px}
  .nav a[aria-current]::after{left:25%;right:25%}
  .consult-num{display:none}
  .case-hero h1{font-size:clamp(40px,7vw,56px)}
  .trio{grid-template-columns:1fr;gap:20px}
  .steps{grid-template-columns:repeat(2,minmax(0,1fr))}
  .cta{grid-template-columns:1fr;gap:24px}
}
@media(max-width:649px){
  .container{width:calc(100% - 40px)}
  .header-inner{height:70px;gap:10px}.brand{gap:8px}.brand img{width:34px}.brand>span{font-size:19px}
  .header-actions .consult{padding:6px 12px;min-height:46px;font-size:11px}
  .menu-toggle{flex:0 0 44px}
  .case-hero{padding-block:34px 28px}
  .case-hero h1{font-size:clamp(38px,9vw,52px)}
  .case-hero .hero-lead{font-size:16px}
  .steps{grid-template-columns:1fr}
  .g2,.g3{grid-template-columns:minmax(0,1fr)}
  .palette{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
  .palette .sw{height:84px}
  .cta{padding-block:40px}
  .footer-bottom{flex-direction:column;align-items:flex-start;gap:18px}
}
@media(max-width:479px){
  .consult-text{display:none}
  .header-actions .consult{padding:5px 8px;min-height:44px}
}
@media(max-width:389px){
  .container{width:calc(100% - 32px)}
  .brand>span{font-size:17px}
  .header-actions .button>span{display:none}
  .header-actions .consult{padding:5px 7px}
  .header-actions .consult .ico-phone{display:grid}
}
@media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}*,*::before,*::after{transition:none!important}}
</style>
</head>
<body>
<a class="skip-link" href="#main">رفتن به محتوای اصلی</a>
<header class="site-header" id="top" data-od-id="site-header"><div class="container header-inner"><a class="brand" href="felosi-home.html" aria-label="استودیو فلوسی، صفحه اصلی" data-od-id="brand"><img src="/assets/header-imgFrame17.svg" width="64" height="54" alt="نشان فلوسی"><span>استودیو فلوسی</span></a><nav class="nav" id="main-nav" aria-label="ناوبری اصلی" data-od-id="main-navigation"><a href="felosi-home.html#portfolio" aria-current="location" data-od-id="nav-portfolio">نمونه‌کارها</a><a href="felosi-home.html#services" data-od-id="nav-services">خدمات</a><a href="felosi-home.html#about" data-od-id="nav-about">درباره ما</a><a href="felosi-home.html#articles" data-od-id="nav-articles">یادداشت‌ها</a></nav><div class="header-actions"><a class="button consult" href="tel:+989120000000" data-od-id="free-consultation" aria-label="تماس تلفنی برای مشاوره رایگان، ۰۹۱۲ ۰۰۰ ۰۰۰۰"><span class="ico-phone" aria-hidden="true"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span><span class="consult-text"><span class="consult-label">مشاوره رایگان</span><span class="consult-num" dir="ltr">۰۹۱۲ ۰۰۰ ۰۰۰۰</span></span></a></div><button class="menu-toggle" type="button" aria-controls="main-nav" aria-expanded="false" aria-label="باز کردن فهرست" data-od-id="mobile-menu">☰</button></div></header>
<main id="main" data-od-id="main-content">
<article class="case-flow">
  <header class="case-hero container" data-od-id="case-hero">
    <nav class="breadcrumb" aria-label="مسیر صفحه"><a href="felosi-home.html#portfolio" data-od-id="breadcrumb-portfolio">نمونه‌کارها</a><span aria-hidden="true">/</span><span aria-current="page">ابراهیمی</span></nav>
    <span class="eyebrow">کیس‌استادی · طراحی لوگو و هویت بصری</span>
    <h1 data-od-id="case-title">ابراهیمی</h1>
    <p class="hero-lead">خلق هویتی لوکس، دقیق و متمایز برای یک مرکز تخصصی بازسازی، تیون ظاهری و نصب آپشن خودرو.</p>
    <ul class="meta" aria-label="مشخصات پروژه">
      <li><span class="meta-k">کارفرما</span><span class="meta-v">ابراهیمی</span></li>
      <li><span class="meta-k">حوزه</span><span class="meta-v">بازسازی، تیون و آپشن خودرو</span></li>
      <li><span class="meta-k">خدمات</span><span class="meta-v" lang="en" dir="ltr">Branding · Graphic</span></li>
    </ul>
    <div class="hero-actions">
      <button class="button solid" type="button" data-contact="project" data-od-id="case-start-project">شروع پروژه <span aria-hidden="true">↖</span></button>
      <a class="button outline" href="tel:+989120000000" data-od-id="case-phone">مشاوره تلفنی: ۰۹۱۲ ۰۰۰ ۰۰۰۰</a>
    </div>
  </header>

  <figure class="cover" data-od-id="case-cover">
    <img src="/16.jpg" width="1920" height="1080" alt="صحنهٔ کارگاه با تابلوی EBRAHIMI بر دیوار و صندلی مسابقه‌ای حمل‌کنندهٔ نشان برند" fetchpriority="high" decoding="async">
    <figcaption>هویت ابراهیمی در فضای کارگاه</figcaption>
  </figure>

  <section class="case-section" aria-labelledby="overview-title">
    <div class="container inner">
      <div class="sec-head" data-od-id="overview-head">
        <span class="eyebrow"><span class="index">۰۰</span> · درباره پروژه</span>
        <h2 id="overview-title" data-od-id="overview-title">یک برند خودرویی، به‌دور از کلیشه.</h2>
      </div>
      <div class="trio">
        <article data-od-id="overview-scope"><h3>نگاه کلی</h3><p>ابراهیمی یک مرکز تخصصی بازسازی، تیون ظاهری و نصب آپشن خودرو است؛ مجموعه‌ای که مخاطبانش به کیفیت، جزئیات و ظاهر خودروی خود اهمیت ویژه‌ای می‌دهند.</p></article>
        <article data-od-id="overview-challenge"><h3>چالش</h3><p>کارفرما هویتی لوکس، دقیق و متمایز می‌خواست؛ برندی که در نگاه اول حس تخصص و کیفیت بدهد و در عین ارتباط با دنیای خودرو، از کلیشه‌های رایج این حوزه فاصله بگیرد.</p></article>
        <article data-od-id="overview-approach"><h3>رویکرد</h3><p>از تحلیل بریف و تعریف مسیر بصری تا طراحی لوگو و توسعهٔ هویت، همراه برند بودیم؛ با تمرکز بر تبدیل دقت، کیفیت، جزئیات و لوکس‌بودن به یک زبان بصری کاربردی.</p></article>
      </div>
      <ol class="steps" aria-label="مراحل پروژه">
        <li data-od-id="step-brief"><span class="step-n">۰۱</span><h3>تحلیل بریف</h3><p>شناخت مخاطب، رقبا و جایگاه برند در بازار خودرو.</p></li>
        <li data-od-id="step-direction"><span class="step-n">۰۲</span><h3>مسیر بصری</h3><p>تعریف یک زبان بصری متمایز و به‌دور از کلیشه.</p></li>
        <li data-od-id="step-logo"><span class="step-n">۰۳</span><h3>طراحی لوگو</h3><p>طراحی وردمارک و لترفرم با تناسبات طلایی.</p></li>
        <li data-od-id="step-identity"><span class="step-n">۰۴</span><h3>توسعهٔ هویت</h3><p>بسط سیستم بصری روی همهٔ نقاط تماس برند.</p></li>
      </ol>
    </div>
  </section>

  <section class="case-section" id="structure" aria-labelledby="structure-title">
    <button class="band" type="button" data-lightbox="02.jpg" data-caption="بخش‌بندی: نسبت طلایی" aria-label="نمایش تصویر بخش نسبت طلایی"><img src="/02.jpg" width="1920" height="1080" alt="صفحهٔ بخش‌بند «GOLDEN RATIO» از دفتر هویت برند" loading="lazy" decoding="async"></button>
    <div class="container inner">
      <div class="sec-head" data-od-id="structure-head">
        <span class="eyebrow"><span class="index">۰۱</span> · لوگو و ساختار</span>
        <h2 id="structure-title" data-od-id="structure-title">از حرف تا نشان، با هندسه‌ای دقیق.</h2>
        <p class="sec-lead">لوگو در قالب وردمارک و لترفرم طراحی شد؛ فرمی مینیمال و مرتبط با خودرو که حس دقت، خاص‌بودن و کیفیت را منتقل می‌کند. تناسبات لوگو با نسبت طلایی تنظیم شد و برای آن حاشیهٔ ایمن و اندازه‌های گوناگون تعریف شد.</p>
      </div>
      <div class="fig-grid g3">
        <button class="fig" type="button" data-lightbox="03.jpg" data-caption="ساختار هندسی لوگو بر پایهٔ نسبت طلایی" aria-label="نمایش ساختار هندسی لوگو"><img src="/03.jpg" width="1920" height="1080" alt="سه ساختار هندسی لوگو بر پایهٔ مثلث و نسبت طلایی" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="05.jpg" data-caption="ساختار لوگو و نوشتار CAR RESTORATION CENTER" aria-label="نمایش ساختار لوگو و نوشتار"><img src="/05.jpg" width="1920" height="1080" alt="ساختار نشان EB و عبارت CAR RESTORATION CENTER روی شبکهٔ نسبت طلایی" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="04.jpg" data-caption="حاشیهٔ ایمن لوگو (Safe Zone)" aria-label="نمایش حاشیهٔ ایمن لوگو"><img src="/04.jpg" width="1920" height="1080" alt="نمودار حاشیهٔ ایمن لوگو با فاصلهٔ x و ارتفاع ۳x" loading="lazy" decoding="async"></button>
        <button class="fig wide" type="button" data-lightbox="01.jpg" data-caption="جلد دفتر هویت برند ابراهیمی" aria-label="نمایش جلد دفتر هویت برند"><img src="/01.jpg" width="1920" height="1080" alt="جلد دفتر هویت برند با عنوان BRAND BOOK" loading="lazy" decoding="async"></button>
      </div>
    </div>
  </section>

  <section class="case-section" id="scale" aria-labelledby="scale-title">
    <button class="band" type="button" data-lightbox="06.jpg" data-caption="بخش‌بندی: مقیاس" aria-label="نمایش تصویر بخش مقیاس"><img src="/06.jpg" width="1920" height="1080" alt="صفحهٔ بخش‌بند «SCALE UP» از دفتر هویت برند" loading="lazy" decoding="async"></button>
    <div class="container inner">
      <div class="sec-head" data-od-id="scale-head">
        <span class="eyebrow"><span class="index">۰۲</span> · مقیاس و خوانایی</span>
        <h2 id="scale-title" data-od-id="scale-title">خوانا در هر اندازه‌ای.</h2>
        <p class="sec-lead">نشان و وردمارک در اندازه‌های گوناگون، از آیکون کوچک تا تابلوی بزرگ، متعادل و خوانا باقی می‌مانند.</p>
      </div>
      <div class="fig-grid g2">
        <button class="fig" type="button" data-lightbox="07.jpg" data-caption="مقیاس‌پذیری نشان" aria-label="نمایش مقیاس‌پذیری نشان"><img src="/07.jpg" width="1920" height="1080" alt="نشان EB در ده اندازهٔ مختلف از بزرگ تا کوچک" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="08.jpg" data-caption="مقیاس‌پذیری وردمارک EBRAHIMI" aria-label="نمایش مقیاس‌پذیری وردمارک"><img src="/08.jpg" width="1920" height="1080" alt="وردمارک EBRAHIMI در ده اندازهٔ مختلف از بزرگ تا کوچک" loading="lazy" decoding="async"></button>
      </div>
    </div>
  </section>

  <section class="case-section" id="color" aria-labelledby="color-title">
    <button class="band" type="button" data-lightbox="09.jpg" data-caption="بخش‌بندی: رنگ" aria-label="نمایش تصویر بخش رنگ"><img src="/09.jpg" width="1920" height="1080" alt="صفحهٔ بخش‌بند «COLOR» از دفتر هویت برند" loading="lazy" decoding="async"></button>
    <div class="container inner">
      <div class="sec-head" data-od-id="color-head">
        <span class="eyebrow"><span class="index">۰۳</span> · رنگ</span>
        <h2 id="color-title" data-od-id="color-title">پالتی از عمق، انرژی و خنثی.</h2>
        <p class="sec-lead">پالت برند بر پایهٔ یک سرمه‌ای عمیق بنا شده است؛ رنگ تأکیدی زرد انرژی و توجه می‌آورد و آبی الکتریک حس مدرن‌بودن را تقویت می‌کند. نسخه‌های تک‌رنگ، کاربرد لوگو روی تصاویر و زمینه‌های رنگی را ممکن می‌کنند.</p>
      </div>
      <ul class="palette" aria-label="پالت رنگ برند">
        <li data-od-id="swatch-navy" style="--sw:#012233"><span class="sw" aria-hidden="true"></span><span class="sw-meta"><b>سرمه‌ای عمیق</b><code>#012233</code></span></li>
        <li data-od-id="swatch-blue" style="--sw:#4140C0"><span class="sw" aria-hidden="true"></span><span class="sw-meta"><b>آبی الکتریک</b><code>#4140C0</code></span></li>
        <li data-od-id="swatch-yellow" style="--sw:#FFBE00"><span class="sw" aria-hidden="true"></span><span class="sw-meta"><b>زرد تأکیدی</b><code>#FFBE00</code></span></li>
        <li data-od-id="swatch-black" style="--sw:#000000"><span class="sw" aria-hidden="true"></span><span class="sw-meta"><b>مشکی</b><code>#000000</code></span></li>
        <li data-od-id="swatch-white" style="--sw:#FFFFFF"><span class="sw" aria-hidden="true"></span><span class="sw-meta"><b>سفید</b><code>#FFFFFF</code></span></li>
        <li data-od-id="swatch-gray" style="--sw:#CCCCCC"><span class="sw" aria-hidden="true"></span><span class="sw-meta"><b>خاکستری</b><code>#CCCCCC</code></span></li>
      </ul>
      <div class="fig-grid g3">
        <button class="fig wide" type="button" data-lightbox="10.jpg" data-caption="نسبت رنگ‌های پالت برند (۶۰/۳۰/۱۰)" aria-label="نمایش نسبت رنگ‌های پالت"><img src="/10.jpg" width="1920" height="1080" alt="نمودار نسبت رنگ با درصدهای ۶۰ و ۳۰ و ۱۰" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="11.jpg" data-caption="مقیاس خاکستری رنگ اصلی" aria-label="نمایش مقیاس خاکستری"><img src="/11.jpg" width="1920" height="1080" alt="میله‌های مقیاس خاکستری از مشکی تا سفید" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="13.jpg" data-caption="نشان روی صفحهٔ گوشی و پالت رنگ" aria-label="نمایش نشان روی صفحهٔ گوشی"><img src="/13.jpg" width="1920" height="1080" alt="نشان EB روی صفحهٔ گوشی همراه با بلوک‌های پالت رنگ" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="14.jpg" data-caption="نسخه‌های رنگی نشان" aria-label="نمایش نسخه‌های رنگی نشان"><img src="/14.jpg" width="1920" height="1080" alt="نشان EB و عبارت CAR RESTORATION CENTER در ترکیب‌های رنگی مختلف" loading="lazy" decoding="async"></button>
        <button class="fig wide" type="button" data-lightbox="15.jpg" data-caption="نسخه‌های رنگی وردمارک EBRAHIMI" aria-label="نمایش نسخه‌های رنگی وردمارک"><img src="/15.jpg" width="1920" height="1080" alt="وردمارک EBRAHIMI در ترکیب‌های رنگی مختلف روی زمینه‌های تیره و روشن" loading="lazy" decoding="async"></button>
      </div>
    </div>
  </section>

  <section class="case-section" id="typography" aria-labelledby="type-title">
    <button class="band" type="button" data-lightbox="26.jpg" data-caption="بخش‌بندی: تایپوگرافی" aria-label="نمایش تصویر بخش تایپوگرافی"><img src="/26.jpg" width="1920" height="1080" alt="صفحهٔ بخش‌بند «TYPOGRAPHY» از دفتر هویت برند" loading="lazy" decoding="async"></button>
    <div class="container inner">
      <div class="sec-head" data-od-id="type-head">
        <span class="eyebrow"><span class="index">۰۴</span> · تایپوگرافی</span>
        <h2 id="type-title" data-od-id="type-title">دو زبان، یک شخصیت.</h2>
        <p class="sec-lead">نوشتار لاتین برند با یک تایپ‌فیس هندسی و مینیمال همراه است؛ برای متون فارسی از IRANSans استفاده می‌شود تا خوانایی در کنار شخصیت بصری حفظ شود.</p>
      </div>
      <div class="fig-grid g2">
        <button class="fig" type="button" data-lightbox="27.jpg" data-caption="مقیاس تایپوگرافی لاتین برند" aria-label="نمایش مقیاس تایپوگرافی لاتین"><img src="/27.jpg" width="1920" height="1080" alt="مقیاس اندازه‌های تایپوگرافی لاتین برای عبارت CAR RESTORATION CENTER" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="28.jpg" data-caption="مقیاس تایپوگرافی فارسی با IRANSans" aria-label="نمایش مقیاس تایپوگرافی فارسی"><img src="/28.jpg" width="1920" height="1080" alt="مقیاس اندازه‌های عنوان و متن فارسی با فونت IRANSans" loading="lazy" decoding="async"></button>
      </div>
    </div>
  </section>

  <section class="case-section" id="touchpoints" aria-labelledby="touchpoints-title">
    <button class="band" type="button" data-lightbox="12.jpg" data-caption="بخش‌بندی: ماکاپ" aria-label="نمایش تصویر بخش ماکاپ"><img src="/12.jpg" width="1920" height="1080" alt="صفحهٔ بخش‌بند «MOCKUP» از دفتر هویت برند" loading="lazy" decoding="async"></button>
    <div class="container inner">
      <div class="sec-head" data-od-id="touchpoints-head">
        <span class="eyebrow"><span class="index">۰۵</span> · نقاط تماس برند</span>
        <h2 id="touchpoints-title" data-od-id="touchpoints-title">هویت در دنیای واقعی.</h2>
        <p class="sec-lead">هویت طراحی‌شده، شخصیت لوکس و کاریزماتیک برند را در نقاط تماس مختلف منتقل می‌کند. سیستم در کارت ویزیت، سربرگ، پاکت، فاکتور و دیگر اقلام توسعه یافت تا تجربه‌ای حرفه‌ای و قابل تشخیص بسازد.</p>
      </div>
      <div class="fig-grid g2">
        <button class="fig wide" type="button" data-lightbox="17.jpg" data-caption="نشان روی بدنهٔ خودرو" aria-label="نمایش نشان روی بدنهٔ خودرو"><img src="/17.jpg" width="1920" height="1080" alt="نشان EB روی بدنهٔ خودروی لوکس" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="18.jpg" data-caption="تابلو و سایناژ مرکز بازسازی" aria-label="نمایش تابلو و سایناژ مرکز"><img src="/18.jpg" width="1920" height="1080" alt="تابلوی EBRAHIMI در فضای فروش و بازسازی خودرو" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="19.jpg" data-caption="تابلو و صندلی مسابقه‌ای با نشان برند" aria-label="نمایش تابلو و صندلی مسابقه‌ای"><img src="/19.jpg" width="1920" height="1080" alt="تابلوی بلند EBRAHIMI کنار صندلی مسابقه‌ای در فضای کارگاه" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="20.jpg" data-caption="تابلوی کلاسیک با نشان و وردمارک" aria-label="نمایش تابلوی کلاسیک"><img src="/20.jpg" width="1920" height="1080" alt="تابلوی ایستاده با نشان EB و وردمارک EBRAHIMI" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="21.jpg" data-caption="نشان سه‌بعدی نصب‌شده روی دیوار" aria-label="نمایش نشان سه‌بعدی روی دیوار"><img src="/21.jpg" width="1920" height="1080" alt="نشان سه‌بعدی گرد زردرنگ EB روی دیوار تیره" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="22.jpg" data-caption="کارت ویزیت طلایی و پرچم تبلیغاتی" aria-label="نمایش کارت ویزیت و پرچم"><img src="/22.jpg" width="1920" height="1080" alt="کارت ویزیت طلایی برند ابراهیمی و پرچم تبلیغاتی روی پایه" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="23.jpg" data-caption="بروشور و پوشهٔ برند" aria-label="نمایش بروشور و پوشه"><img src="/23.jpg" width="1920" height="1080" alt="بروشور و پوشهٔ برند با نشان و وردمارک ابراهیمی" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="25.jpg" data-caption="کلاه با نشان برند" aria-label="نمایش کلاه با نشان برند"><img src="/25.jpg" width="1920" height="1080" alt="کلاه آبی‌رنگ با نشان زرد EB" loading="lazy" decoding="async"></button>
      </div>
    </div>
  </section>

  <section class="case-section" id="icon" aria-labelledby="icon-title">
    <button class="band" type="button" data-lightbox="29.jpg" data-caption="بخش‌بندی: آیکون" aria-label="نمایش تصویر بخش آیکون"><img src="/29.jpg" width="1920" height="1080" alt="صفحهٔ بخش‌بند «ICON» از دفتر هویت برند" loading="lazy" decoding="async"></button>
    <div class="container inner">
      <div class="sec-head" data-od-id="icon-head">
        <span class="eyebrow"><span class="index">۰۶</span> · سیستم آیکون</span>
        <h2 id="icon-title" data-od-id="icon-title">یک زبان، همهٔ نمادها.</h2>
        <p class="sec-lead">مجموعه‌ای از آیکون‌ها با زبان هندسی و هم‌خوان با لوگو طراحی شد تا در رابط‌های دیجیتال و اقلام چاپی یکدست بماند.</p>
      </div>
      <button class="fig" type="button" data-lightbox="30.jpg" data-caption="مجموعهٔ آیکون‌های برند" aria-label="نمایش مجموعهٔ آیکون‌ها"><img src="/30.jpg" width="1920" height="1080" alt="شبکهٔ بزرگ آیکون‌های خطی برند در دسته‌های گوناگون" loading="lazy" decoding="async"></button>
    </div>
  </section>

  <section class="case-section" id="guides" aria-labelledby="guides-title">
    <button class="band" type="button" data-lightbox="33.jpg" data-caption="بخش‌بندی: راهنما" aria-label="نمایش تصویر بخش راهنما"><img src="/33.jpg" width="1920" height="1080" alt="صفحهٔ بخش‌بند «GUIDES» از دفتر هویت برند" loading="lazy" decoding="async"></button>
    <div class="container inner">
      <div class="sec-head" data-od-id="guides-head">
        <span class="eyebrow"><span class="index">۰۷</span> · راهنمای برند</span>
        <h2 id="guides-title" data-od-id="guides-title">قواعدی که هویت را منسجم نگه می‌دارد.</h2>
        <p class="sec-lead">قواعد استفاده، رفتار نشان روی زمینه‌های رنگی و تصویری، و نسخه‌های تک‌رنگ لوگو تعریف شد تا هویت در همهٔ کاربردها یکدست بماند.</p>
      </div>
      <div class="fig-grid g2">
        <button class="fig" type="button" data-lightbox="32.jpg" data-caption="رفتار نشان روی زمینه‌های رنگی و فرم‌های گرد" aria-label="نمایش رفتار نشان روی زمینه‌های رنگی"><img src="/32.jpg" width="1920" height="1080" alt="شبکه‌ای از نشان EB روی زمینه‌ها و فرم‌های گرد رنگی مختلف" loading="lazy" decoding="async"></button>
        <button class="fig" type="button" data-lightbox="34.jpg" data-caption="قواعد استفاده از نسخهٔ تک‌رنگ لوگو" aria-label="نمایش قواعد نسخهٔ تک‌رنگ"><img src="/34.jpg" width="1920" height="1080" alt="چهار قاعدهٔ استفاده از لوگوی تک‌رنگ روی زمینه‌های تیره و روشن" loading="lazy" decoding="async"></button>
      </div>
    </div>
  </section>

  <figure class="closing-cover" data-od-id="case-thanks">
    <img src="/35.jpg" width="1920" height="1080" alt="صفحهٔ پایانی دفتر هویت برند با عنوان THANKS" loading="lazy" decoding="async">
  </figure>

  <section class="container" aria-labelledby="cta-title">
    <div class="cta">
      <div data-od-id="cta-copy">
        <span class="eyebrow">قدم بعدی</span>
        <h2 id="cta-title" data-od-id="cta-title">پروژهٔ بعدی شما، یک هویت ماندگار.</h2>
        <p>از تحلیل بریف تا توسعهٔ هویت بصری، در کنار شما هستیم. برای مشاورهٔ رایگان تماس بگیرید.</p>
      </div>
      <div class="cta-actions">
        <button class="button solid" type="button" data-contact="project" data-od-id="cta-start-project">شروع پروژه <span aria-hidden="true">↖</span></button>
        <a class="button outline" href="tel:+989120000000" data-od-id="cta-phone">۰۹۱۲ ۰۰۰ ۰۰۰۰</a>
      </div>
    </div>
  </section>
</article>
</main>
<footer class="site-footer" data-od-id="footer"><div class="container footer-bottom"><a class="footer-brand" href="felosi-home.html" aria-label="بازگشت به صفحهٔ اصلی استودیو فلوسی" data-od-id="footer-brand"><img src="/assets/footer-imgUnion.svg" width="92" height="93.8623" alt="فلوسی"><span>استودیو فلوسی</span></a><nav class="footer-nav" aria-label="پیوندهای پایین صفحه" data-od-id="footer-navigation"><a href="felosi-home.html#portfolio">نمونه‌کارها</a><a href="felosi-home.html#services">خدمات</a><a href="felosi-home.html#about">درباره ما</a><a href="#top" data-od-id="footer-top">بازگشت به بالا ↑</a></nav></div></footer>
<dialog id="contact-dialog" aria-labelledby="contact-title" data-od-id="project-dialog"><div class="dialog-head"><h2 id="contact-title" data-od-id="contact-title">شروع پروژه</h2><button type="button" class="close-dialog" data-close aria-label="بستن" data-od-id="close-project-dialog">×</button></div><p class="dialog-note">خلاصهٔ پروژه‌تان را آماده و دریافت کنید. اطلاعات این فرم برای کسی ارسال نمی‌شود.</p><form id="brief-form" class="form-grid" data-od-id="project-form"><label>نام شما<input name="name" autocomplete="name" required maxlength="100" data-od-id="brief-name"></label><label>ایمیل (اختیاری)<input type="email" name="email" autocomplete="email" dir="ltr" data-od-id="brief-email"></label><label>خدمت موردنظر<select name="service" data-od-id="brief-service"><option value="branding" selected>طراحی هویت بصری</option><option value="logo">طراحی لوگو</option><option value="graphic">طراحی گرافیک</option><option value="marketing">دیجیتال مارکتینگ</option><option value="uiux">طراحی رابط و تجربه کاربری</option></select></label><label>درباره پروژه<textarea name="details" maxlength="5000" required rows="4" placeholder="چه چیزی می‌خواهید طراحی کنیم؟" data-od-id="brief-details"></textarea></label><button type="submit" class="button solid" data-od-id="download-brief">دریافت خلاصه پروژه</button><p id="form-status" class="form-status" role="status" aria-live="polite"></p></form></dialog>
<dialog id="lightbox" class="lightbox" aria-labelledby="lightbox-cap" data-od-id="lightbox"><div class="dialog-head"><h2 id="lightbox-cap"></h2><button type="button" class="close-dialog" data-close aria-label="بستن" data-od-id="close-lightbox">×</button></div><img id="lightbox-img" alt=""></dialog>
<script>
(()=>{'use strict';
const menu=document.querySelector('.menu-toggle'),nav=document.getElementById('main-nav');
function closeMenu(){nav.classList.remove('open');menu.setAttribute('aria-expanded','false');menu.setAttribute('aria-label','باز کردن فهرست');menu.textContent='☰'}
menu.addEventListener('click',()=>{const open=menu.getAttribute('aria-expanded')!=='true';nav.classList.toggle('open',open);menu.setAttribute('aria-expanded',String(open));menu.setAttribute('aria-label',open?'بستن فهرست':'باز کردن فهرست');menu.textContent=open?'×':'☰'});
nav.querySelectorAll('a').forEach(a=>a.addEventListener('click',closeMenu));
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeMenu()});
document.addEventListener('click',e=>{if(!e.target.closest('.header-inner'))closeMenu()});
window.matchMedia('(min-width:900px)').addEventListener('change',e=>{if(e.matches)closeMenu()});
const contact=document.getElementById('contact-dialog'),lightbox=document.getElementById('lightbox'),form=document.getElementById('brief-form');
function openDialog(dialog){document.querySelectorAll('dialog[open]').forEach(d=>d.close());dialog.showModal();document.body.style.overflow='hidden'}
document.querySelectorAll('dialog').forEach(d=>{d.querySelector('[data-close]').addEventListener('click',()=>d.close());d.addEventListener('close',()=>{document.body.style.overflow=''});d.addEventListener('click',e=>{if(e.target===d){const r=d.getBoundingClientRect();if(e.clientX<r.left||e.clientX>r.right||e.clientY<r.top||e.clientY>r.bottom)d.close()}})});
document.querySelectorAll('[data-contact]').forEach(b=>b.addEventListener('click',()=>{const t=document.getElementById('contact-title');t.textContent='شروع پروژه';document.getElementById('form-status').textContent='';openDialog(contact)}));
document.querySelectorAll('[data-lightbox]').forEach(b=>b.addEventListener('click',()=>{const img=document.getElementById('lightbox-img');img.src=b.dataset.lightbox;img.alt=b.querySelector('img').alt;document.getElementById('lightbox-cap').textContent=b.dataset.caption||'';openDialog(lightbox)}));
try{const saved=JSON.parse(localStorage.getItem('felosi-project-brief')||'null');if(saved)for(const key of ['name','email','service','details'])if(typeof saved[key]==='string')form.elements[key].value=saved[key]}catch{}
form.addEventListener('submit',e=>{e.preventDefault();if(!form.reportValidity())return;const data=Object.fromEntries(new FormData(form)),service=form.elements.service.selectedOptions[0].textContent;const brief=['خلاصه پروژه — استودیو فلوسی','','نام: '+data.name,'ایمیل: '+data.email,'خدمت: '+service,'','توضیحات پروژه:',data.details].join('\n');try{localStorage.setItem('felosi-project-brief',JSON.stringify(data))}catch{}const url=URL.createObjectURL(new Blob(['\ufeff'+brief],{type:'text/plain;charset=utf-8'}));const a=document.createElement('a');a.href=url;a.download='felosi-project-brief.txt';document.body.append(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),1000);document.getElementById('form-status').textContent='خلاصه پروژه آماده شد. هیچ اطلاعاتی ارسال نشده است.'});
})();
</script>
</body></html>

@endverbatim
