<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>https://flowsee.ir/blog</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>
    @foreach($posts as $post)
        <url><loc>{{ route('blog.show', $post->slug) }}</loc><lastmod>{{ $post->updated_at->toAtomString() }}</lastmod></url>
    @endforeach
</urlset>
