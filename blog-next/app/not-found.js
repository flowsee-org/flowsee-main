import Link from 'next/link';
export default function NotFound() {
  return <main id="blog-main" className="container blog-empty"><h1>این دسته‌بندی پیدا نشد</h1><p>از دسته‌بندی‌های بلاگ یک موضوع انتخاب کنید.</p><Link href="/" className="blog-button">همهٔ مقاله‌ها</Link></main>;
}
