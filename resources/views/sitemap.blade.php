{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>https://flowsee.ir/</loc></url>
    <url><loc>https://flowsee.ir/en</loc></url>
    <url><loc>https://flowsee.ir/blog</loc></url>
    <url><loc>https://flowsee.ir/qazvin-beauty</loc></url>
    <url><loc>https://flowsee.ir/product/e-learning</loc></url>
    @foreach ($projects as $project)
    <url><loc>{{ 'https://flowsee.ir/projects/'.rawurlencode($project->slug) }}</loc><lastmod>{{ max($project->updated_at, $project->caseStudy->updated_at)->toW3cString() }}</lastmod></url>
    @endforeach
</urlset>
