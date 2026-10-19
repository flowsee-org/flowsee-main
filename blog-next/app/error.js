'use client';
export default function BlogError({ reset }) {
  return <main id="blog-main" className="container blog-empty"><h1>دریافت مقاله‌ها انجام نشد</h1><p>لطفاً دوباره تلاش کنید.</p><button className="blog-button" onClick={reset}>تلاش دوباره</button></main>;
}
