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
      <script dangerouslySetInnerHTML={{ __html: `try{document.documentElement.dataset.theme=localStorage.getItem('flowsee-theme')||(matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light')}catch(e){document.documentElement.dataset.theme='light'}` }} />
      <link rel="stylesheet" href="/assets/css/site.css" />
      <link rel="stylesheet" href="/assets/css/mobile.css" />
      <link rel="stylesheet" href="/assets/css/blog.css" />
    </head>
    <body>
      <a className="skip-link" href="#blog-main">رفتن به محتوای اصلی</a>
      <header className="blog-topbar">
        <a href="/" className="blog-brand" aria-label="صفحهٔ اصلی استودیو فلوسی"><span className="blog-brand-mark">F</span><span>استودیو فلوسی</span></a>
        <nav aria-label="ناوبری اصلی"><a href="/">خانه</a><a href="/blog" aria-current="page">بلاگ</a><a href="/#portfolio">نمونه‌کارها</a><a href="/#services">خدمات</a></nav>
        <a className="blog-top-cta" href="/#contact-dialog">مشاوره رایگان</a>
      </header>
      {children}
      <footer className="blog-footer"><a href="/">استودیو فلوسی</a><span>طراحی برای رشد، استراتژی برای ماندگاری.</span><a href="/">صفحهٔ اصلی ↗</a></footer>
      <Script id="flowsee-clarity" strategy="afterInteractive">{`(function(c,l,a,r,i,t,y){c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y)})(window,document,"clarity","script","ywjxxggyxf");`}</Script>
    </body>
  </html>;
}
