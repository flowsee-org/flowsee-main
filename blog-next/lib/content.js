import { cache } from 'react';
import { notFound } from 'next/navigation';
import { listingQuery } from './blog.mjs';

// Read-only Laravel data: Studio publications become visible on the next request, without rebuilding Next.js.
export const getListing = cache(async (category, page) => {
  const origin = process.env.FLOWSEE_CONTENT_ORIGIN || 'https://flowsee.ir';
  const response = await fetch(`${origin}/api/blog${listingQuery(category, page)}`, {
    cache: 'no-store', headers: { Accept: 'application/json' }, signal: AbortSignal.timeout(8000),
  });
  if (response.status === 404) notFound();
  if (!response.ok) throw new Error('Blog content is temporarily unavailable.');
  return response.json();
});
