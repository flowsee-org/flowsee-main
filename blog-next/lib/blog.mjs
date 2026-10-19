export function listingQuery(category = '', page = 1) {
  const query = new URLSearchParams();
  if (category) query.set('category', category);
  if (page > 1) query.set('page', String(page));
  return query.size ? `?${query}` : '';
}

export function normalizePage(value) {
  const page = Number(value || 1);
  return Number.isSafeInteger(page) && page > 0 ? page : null;
}

export function listingMeta(category, page = 1) {
  const title = category ? `${category.name} | بلاگ استودیو فلوسی` : 'بلاگ استودیو فلوسی | ایده‌ها و راهنمای طراحی و رشد';
  return {
    title: page > 1 ? `${title} | صفحهٔ ${page}` : title,
    description: category?.description || 'مقاله‌ها، تجربه‌ها و راهنماهای کاربردی استودیو فلوسی دربارهٔ برندینگ، طراحی دیجیتال و بازاریابی.',
    url: `https://flowsee.ir/blog${listingQuery(category?.slug, page)}`,
  };
}
