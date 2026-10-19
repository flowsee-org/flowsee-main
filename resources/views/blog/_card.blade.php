<a class="blog-card {{ ($bento ?? false) ? 'blog-bento-card '.($featured ? 'blog-bento-large' : '') : ($featured ? 'blog-card-featured' : '') }}" href="{{ route('blog.show', $post->slug) }}">
    <span class="blog-card-image">
        @if($post->cover_image)
            <img src="{{ \App\Support\WebsiteMediaUrl::for($post->cover_image) }}" alt="{{ $post->cover_alt ?: $post->title }}" loading="lazy" decoding="async">
        @else
            <span class="blog-card-art" aria-hidden="true"><span>F</span></span>
        @endif
        @if($featured)<span class="blog-card-featured-label">پیشنهاد فلوسی</span>@endif
    </span>
    <span class="blog-card-copy">
        <span class="blog-card-meta"><span>{{ $post->category?->name }}</span><time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('j F Y') }}</time></span>
        <span class="blog-card-title">{{ $post->title }}</span>
        @if($post->excerpt)<span class="blog-card-excerpt">{{ $post->excerpt }}</span>@endif
        <span class="blog-card-read">خواندن مقاله <span aria-hidden="true">↗</span></span>
    </span>
</a>
