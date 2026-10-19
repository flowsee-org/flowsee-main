import Link from 'next/link';
import { notFound } from 'next/navigation';
import FilterLink from './filter-link';
import { getListing } from '../lib/content';
import { listingMeta, listingQuery, normalizePage } from '../lib/blog.mjs';

async function requestListing(searchParams) {
  const params = await searchParams;
  const page = normalizePage(params.page);
  if (page === null || Array.isArray(params.category) || Array.isArray(params.page)) notFound();
  return getListing(params.category || '', page);
}

export async function generateMetadata({ searchParams }) {
  const data = await requestListing(searchParams);
  const meta = listingMeta(data.category, data.pagination.currentPage);
  return {
    title: meta.title, description: meta.description, alternates: { canonical: meta.url },
    openGraph: { type: 'website', locale: 'fa_IR', siteName: 'استودیو فلوسی | Flowsee', title: meta.title, description: meta.description, url: meta.url, images: ['https://flowsee.ir/assets/flowsee-social.jpg'] },
    twitter: { card: 'summary_large_image', title: meta.title, description: meta.description, images: ['https://flowsee.ir/assets/flowsee-social.jpg'] },
  };
}

export default async function BlogPage({ searchParams }) {
  const { categories, category, posts, pagination } = await requestListing(searchParams);
  const meta = listingMeta(category, pagination.currentPage);
  const structuredData = {
    '@context': 'https://schema.org', '@type': 'CollectionPage', name: meta.title, url: meta.url, description: meta.description, inLanguage: 'fa-IR',
    mainEntity: { '@type': 'ItemList', itemListElement: posts.map((post, index) => ({ '@type': 'ListItem', position: (pagination.currentPage - 1) * pagination.perPage + index + 1, url: `https://flowsee.ir/blog/${post.slug}` })) },
  };
  return <main id="blog-main" className="blog-page" data-flowsee-next-blog="true">
    <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData).replace(/</g, '\\u003c') }} />
    <section className="blog-hero container">
      <div className="blog-hero-copy"><span className="blog-eyebrow"><span />مجلهٔ فلوسی</span>
        <h1>{category?.name || 'ایده‌هایی برای برندهای رو به رشد.'}</h1>
        <p>{category?.description || 'نگاه‌ها، تجربه‌ها و راهنماهای کاربردی دربارهٔ برندینگ، طراحی و رشد در دنیای دیجیتال.'}</p>
        <div className="blog-hero-note"><span>دانش طراحی</span><span>تجربهٔ واقعی</span><span>نگاه کاربردی</span></div>
      </div>
      <div className="blog-hero-art" aria-hidden="true"><span className="blog-hero-orbit blog-hero-orbit-one" /><span className="blog-hero-orbit blog-hero-orbit-two" /><span className="blog-hero-monogram">F</span><span className="blog-hero-caption">طراحی برای رشد<br />استراتژی برای ماندگاری</span></div>
    </section>
    <section className="container blog-listing" aria-labelledby="blog-list-title">
      <div className="blog-section-heading"><div><span className="blog-eyebrow"><span />از دیدگاه ما</span><h2 id="blog-list-title">مقاله‌ها و راهنماها</h2></div><span className="blog-result-count" role="status" aria-live="polite">{pagination.total.toLocaleString('fa-IR')} مقاله</span></div>
      <nav className="blog-categories" aria-label="دسته‌بندی مقاله‌ها">
        <FilterLink href="/" active={!category}>همهٔ مقاله‌ها</FilterLink>
        {categories.map(item => <FilterLink key={item.id} href={`/${listingQuery(item.slug)}`} active={category?.id === item.id}>{item.name}</FilterLink>)}
      </nav>
      {posts.length ? <div className="blog-grid blog-grid-transition" key={`${category?.slug || 'all'}-${pagination.currentPage}`}>
        {posts.map((post, index) => {
          const featured = pagination.currentPage === 1 && index === 0;
          return <a className={`blog-card${featured ? ' blog-card-featured' : ''}`} href={`/blog/${post.slug}`} key={post.id}>
            <span className="blog-card-image">
              {post.coverUrl ? <img src={post.coverUrl} alt={post.coverAlt} loading={index === 0 ? 'eager' : 'lazy'} decoding="async" /> : <span className="blog-card-art" aria-hidden="true"><span>F</span></span>}
              {featured && <span className="blog-card-featured-label">پیشنهاد فلوسی</span>}
            </span>
            <span className="blog-card-copy"><span className="blog-card-meta"><span>{post.category?.name}</span><time dateTime={post.publishedAt}>{new Intl.DateTimeFormat('fa-IR', { dateStyle: 'long', timeZone: 'Asia/Tehran' }).format(new Date(post.publishedAt))}</time></span>
              <span className="blog-card-title">{post.title}</span>{post.excerpt && <span className="blog-card-excerpt">{post.excerpt}</span>}<span className="blog-card-read">خواندن مقاله <span aria-hidden="true">↗</span></span>
            </span>
          </a>;
        })}
      </div> : <div className="blog-empty"><span className="blog-empty-mark">F</span><h3>مقاله‌ها به‌زودی منتشر می‌شوند</h3><p>به‌زودی تجربه‌ها و راهنماهای تازهٔ فلوسی را همین‌جا می‌خوانید.</p><a href="/" className="blog-button">بازگشت به صفحهٔ اصلی</a></div>}
      {pagination.lastPage > 1 && <nav className="blog-pagination" aria-label="صفحه‌بندی مقاله‌ها">
        {pagination.currentPage > 1 && <Link href={`/${listingQuery(category?.slug, pagination.currentPage - 1)}`} scroll={false}>صفحهٔ قبل</Link>}
        <span>{pagination.currentPage.toLocaleString('fa-IR')} / {pagination.lastPage.toLocaleString('fa-IR')}</span>
        {pagination.currentPage < pagination.lastPage && <Link href={`/${listingQuery(category?.slug, pagination.currentPage + 1)}`} scroll={false}>صفحهٔ بعد</Link>}
      </nav>}
    </section>
  </main>;
}
