@php
    $footerHome = $isEnglish ? '/en' : '/';
    $footerPortfolio = $footerHome.'#portfolio';
    $footerServices = $footerHome.'#services';
    $footerBlog = $isEnglish ? '/en#technology-stacks' : route('blog.index');
@endphp
<footer class="site-footer blog-site-footer">
    <div class="container footer-inner">
        <a class="footer-brand" href="{{ $footerHome }}#top" aria-label="{{ $isEnglish ? 'Flowsee Studio home' : 'بازگشت به ابتدای صفحه' }}">
            <img src="/assets/footer-imgUnion.svg" alt="{{ $isEnglish ? 'Flowsee' : 'فلوسی' }}" width="92" height="94" loading="lazy" decoding="async">
        </a>
        <nav class="footer-nav" aria-label="{{ $isEnglish ? 'Footer navigation' : 'پیوندهای پایین صفحه' }}">
            <a href="{{ $footerPortfolio }}">{{ $isEnglish ? 'Portfolio' : 'نمونه‌کارها' }}</a>
            <a href="{{ $footerServices }}">{{ $isEnglish ? 'Services' : 'خدمات' }}</a>
            <a href="{{ $footerBlog }}">{{ $isEnglish ? 'Blog' : 'بلاگ' }}</a>
        </nav>
        <div class="socials" aria-label="{{ $isEnglish ? 'Flowsee contact and social links' : 'راه‌های ارتباطی' }}">
            <a class="social social-instagram" href="https://www.instagram.com/flowsee.ir/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="/assets/footer-imgInstagram1.svg" width="32" height="32" alt="" loading="lazy" decoding="async"></a>
            <a class="social social-telegram" href="https://t.me/flowseeadmin" target="_blank" rel="noopener noreferrer" aria-label="Telegram"><img src="/assets/footer-imgTelegram1.svg" width="32" height="32" alt="" loading="lazy" decoding="async"></a>
            <a class="social social-whatsapp" href="https://wa.me/989109027628" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><img src="/assets/footer-imgWhatsapp1.svg" width="32" height="32" alt="" loading="lazy" decoding="async"></a>
            <a class="social social-x" href="https://x.com/flowseeir" target="_blank" rel="noopener noreferrer" aria-label="X"><span class="footer-social-label" aria-hidden="true">𝕏</span></a>
            <a class="social social-map" href="https://maps.app.goo.gl/kN2kZ9AkS6nGbnoC7" target="_blank" rel="noopener noreferrer" aria-label="Google Maps"><img src="/assets/google-maps-logo.webp" width="32" height="32" alt="" loading="lazy" decoding="async"></a>
            <a class="social social-balad" href="https://balad.ir/p/46T1JAasDQclgV" target="_blank" rel="noopener noreferrer" aria-label="Balad"><img src="/assets/balad-logo.png" width="32" height="32" alt="" loading="lazy" decoding="async"></a>
            <a class="social social-gmail" href="mailto:flowseeadmin@gmail.com" aria-label="Email"><img src="/assets/footer-imgGmail1.svg" width="32" height="32" alt="" loading="lazy" decoding="async"></a>
        </div>
    </div>
</footer>
