@props(['path', 'alt' => '', 'sizes' => '(max-width: 1199px) 100vw, 1200px'])
@php
    $dimensions = \App\Support\WebsiteMediaUrl::dimensionsFor($path);
    $srcset = \App\Support\WebsiteMediaUrl::previewSrcsetFor($path);
@endphp
<img src="{{ \App\Support\WebsiteMediaUrl::previewFor($path) }}" @if($srcset) srcset="{{ $srcset }}" sizes="{{ $sizes }}" @endif width="{{ $dimensions[0] }}" height="{{ $dimensions[1] }}" alt="{{ $alt }}" {{ $attributes->merge(['decoding' => 'async']) }}>
