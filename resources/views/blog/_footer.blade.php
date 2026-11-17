@php
    $footerHome = $isEnglish ? '/en' : '/';
    $footerBlog = $isEnglish ? '/en#technology-stacks' : route('blog.index');
    $footerLinks = $isEnglish
        ? [['Home', $footerHome], ['Portfolio', $footerHome.'#portfolio'], ['Services', $footerHome.'#services'], ['Technology guides', $footerBlog]]
        : [['خانه', $footerHome], ['نمونه‌کارها', $footerHome.'#portfolio'], ['خدمات', $footerHome.'#services'], ['مجلهٔ فلوسی', $footerBlog]];
@endphp
<footer class="blog-footer">
    <div class="blog-footer-inner">
        <div class="blog-footer-brand-block">
            <a class="blog-footer-brand" href="{{ $footerHome }}" aria-label="{{ $isEnglish ? 'Flowsee Studio home' : 'صفحهٔ اصلی استودیو فلوسی' }}">
                <img src="{{ asset('favicon.svg') }}" width="42" height="36" alt="" loading="lazy" decoding="async">
                <span>{{ $isEnglish ? 'Flowsee Studio' : 'استودیو فلوسی' }}</span>
            </a>
            <p>{{ $isEnglish ? 'Design for growth. Strategy for longevity.' : 'طراحی برای رشد؛ استراتژی برای ماندگاری.' }}</p>
        </div>
        <nav class="blog-footer-links" aria-label="{{ $isEnglish ? 'Footer navigation' : 'پیوندهای پایانی' }}">
            @foreach($footerLinks as [$label, $href])<a href="{{ $href }}">{{ $label }}</a>@endforeach
        </nav>
        <span class="blog-footer-copy">© {{ date('Y') }} Flowsee</span>
    </div>
</footer>
