import './navigation.css';
import Script from 'next/script';

export const metadata = {
  metadataBase: new URL('https://flowsee.ir'),
  robots: { index: true, follow: true, 'max-image-preview': 'large' },
  icons: { icon: '/favicon.svg' },
  verification: { google: 'UAQcvYOs7dLeVV987bTILlMz0EU8I0LTdyOlBlKpfeA' },
};

export default function RootLayout({ children }) {
  return <html lang="fa" dir="rtl" suppressHydrationWarning>
    <head>
      <meta name="theme-color" content="#FE5400" />
      <script dangerouslySetInnerHTML={{ __html: `try{document.documentElement.dataset.theme=localStorage.getItem('flowsee-theme')||'light'}catch(e){document.documentElement.dataset.theme='light'}` }} />
      <link rel="stylesheet" href="/assets/css/site.css" />
      <link rel="stylesheet" href="/assets/css/mobile.css" />
      <link rel="stylesheet" href="/assets/css/blog.css" />
    </head>
    <body>
      <a className="skip-link" href="#blog-main">رفتن به محتوای اصلی</a>
      <header className="blog-topbar">
        <a href="/" className="blog-brand" aria-label="صفحهٔ اصلی استودیو فلوسی"><span className="blog-brand-mark">F</span><span>استودیو فلوسی</span></a>
        <nav aria-label="ناوبری اصلی"><a href="/">خانه</a><a href="/blog" aria-current="page">بلاگ</a><a href="/#portfolio">نمونه‌کارها</a><a href="/#services">خدمات</a></nav>
        <div className="blog-header-actions">
          <button type="button" className="blog-theme-toggle" data-blog-theme-toggle aria-label="فعال‌کردن حالت تاریک" title="فعال‌کردن حالت تاریک" aria-pressed="false"><svg viewBox="0 0 24 24" aria-hidden="true"><circle className="blog-theme-sun" cx="12" cy="12" r="4"/><path className="blog-theme-sun" d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/><path className="blog-theme-moon" d="M20.2 15.3A8.5 8.5 0 0 1 8.7 3.8 8.5 8.5 0 1 0 20.2 15.3Z"/></svg><span className="sr-only" data-blog-theme-label>حالت تاریک</span></button>
          <a className="blog-top-cta" href="/#contact-dialog">مشاوره رایگان</a>
        </div>
      </header>
      {children}
      <footer className="blog-footer"><a href="/">استودیو فلوسی</a><span>طراحی برای رشد، استراتژی برای ماندگاری.</span><a href="/">صفحهٔ اصلی ↗</a></footer>
      <Script id="flowsee-blog-theme" strategy="afterInteractive">{`(()=>{const button=document.querySelector('[data-blog-theme-toggle]');if(!button)return;const label=button.querySelector('[data-blog-theme-label]');function sync(){const dark=document.documentElement.dataset.theme==='dark';const action=dark?'فعال‌کردن حالت روشن':'فعال‌کردن حالت تاریک';button.setAttribute('aria-label',action);button.title=action;button.setAttribute('aria-pressed',String(dark));if(label)label.textContent=dark?'حالت روشن':'حالت تاریک';const meta=document.querySelector('meta[name="theme-color"]');if(meta)meta.content=dark?'#11151b':'#FE5400'}sync();button.addEventListener('click',()=>{const next=document.documentElement.dataset.theme==='dark'?'light':'dark';document.documentElement.dataset.theme=next;try{localStorage.setItem('flowsee-theme',next)}catch(e){}sync()})})();`}</Script>
      <Script id="flowsee-clarity" strategy="afterInteractive">{`(function(c,l,a,r,i,t,y){c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y)})(window,document,"clarity","script","ywjxxggyxf");`}</Script>
    </body>
  </html>;
}
