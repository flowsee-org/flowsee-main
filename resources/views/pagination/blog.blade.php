@if ($paginator->hasPages())
    @if (! $paginator->onFirstPage())
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">صفحهٔ قبل</a>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <span aria-hidden="true">{{ $element }}</span>
        @else
            @foreach ($element as $page => $url)
                @if ($page === $paginator->currentPage())
                    <span aria-current="page" aria-label="صفحهٔ {{ $page }}، صفحهٔ فعلی">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" aria-label="صفحهٔ {{ $page }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">صفحهٔ بعد</a>
    @endif
@endif
