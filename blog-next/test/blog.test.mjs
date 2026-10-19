import { test } from 'node:test';
import assert from 'node:assert/strict';
import { listingQuery, normalizePage, listingMeta } from '../lib/blog.mjs';

test('category links reset pagination, encode input and keep shareable query URLs', () => {
  assert.equal(listingQuery(), '');
  assert.equal(listingQuery('ux-ui'), '?category=ux-ui');
  assert.equal(listingQuery('ux-ui', 2), '?category=ux-ui&page=2');
  assert.equal(listingQuery('', 2), '?page=2');
  assert.equal(listingQuery('a&b'), '?category=a%26b');
});
test('invalid and unbounded page numbers are rejected', () => {
  for (const page of ['0', '-1', 'abc', '1.5', 'Infinity', '9007199254740992']) assert.equal(normalizePage(page), null);
  assert.equal(normalizePage(undefined), 1);
  assert.equal(normalizePage('2'), 2);
});
test('each category and pagination page receives its own canonical and metadata', () => {
  const meta = listingMeta({ name: 'طراحی تجربه کاربری', slug: 'ux-ui', description: 'راهنمای تجربه کاربری' }, 2);
  assert.equal(meta.url, 'https://flowsee.ir/blog?category=ux-ui&page=2');
  assert.equal(meta.description, 'راهنمای تجربه کاربری');
  assert.match(meta.title, /صفحهٔ 2/);
  assert.equal(listingMeta(null).url, 'https://flowsee.ir/blog');
});
