'use client';
import Link, { useLinkStatus } from 'next/link';

function Pending() {
  const { pending } = useLinkStatus();
  return <span className={`blog-filter-progress${pending ? ' is-pending' : ''}`} aria-hidden="true" />;
}

export default function FilterLink({ href, active, children }) {
  return <Link href={href} prefetch={true} scroll={false} className={active ? 'is-active' : ''} aria-current={active ? 'page' : undefined}>
    {children}<Pending />
  </Link>;
}
