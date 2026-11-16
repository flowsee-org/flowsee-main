<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\Project;
use App\Support\WebsiteMediaUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteSeoTest extends TestCase
{
    use RefreshDatabase;

    private function publish(string $slug): BlogPost
    {
        return BlogPost::create([
            'blog_category_id' => BlogCategory::firstOrFail()->id, 'title' => 'Article '.$slug,
            'slug' => $slug, 'content' => '<p>ARTICLE_BODY_NOT_FOR_LISTINGS</p>',
            'is_published' => true, 'published_at' => now()->subDay(),
        ]);
    }

    public function test_blog_with_multiple_pages_renders_crawlable_pagination_and_distinct_canonicals(): void
    {
        foreach (range(1, 10) as $n) {
            $this->publish('story-'.$n);
        }
        $this->get('/blog')->assertOk()->assertSee('rel="next"', false)
            ->assertSee('href="https://flowsee.ir/blog"', false)->assertDontSee('ARTICLE_BODY_NOT_FOR_LISTINGS');
        $response = $this->get('/blog?page=2')->assertOk()->assertSee('rel="prev"', false)
            ->assertSee('rel="canonical" href="https://flowsee.ir/blog?page=2"', false)
            ->assertSee('صفحهٔ 2')->assertDontSee('ARTICLE_BODY_NOT_FOR_LISTINGS');
        $this->assertArrayNotHasKey('content', $response->viewData('posts')->first()->getAttributes());
        $category = BlogCategory::firstOrFail()->slug;
        $this->get('/blog?category='.$category.'&page=2')->assertOk()
            ->assertSee('rel="canonical" href="https://flowsee.ir/blog?category='.$category.'&amp;page=2"', false);
        foreach (['/blog?page=9999', '/blog?page=0', '/blog?page=word', '/blog?page[]=1', '/blog?category[]=x'] as $url) {
            $this->get($url)->assertNotFound();
        }
        $this->getJson('/api/blog?page=9999')->assertNotFound();
    }

    public function test_home_translations_have_reciprocal_alternates_and_english_metadata(): void
    {
        $this->get('/en')->assertOk()->assertSee('<html lang="en"', false)
            ->assertSee('rel="canonical" href="https://flowsee.ir/en"', false)
            ->assertSee('Flowsee Studio | Brand Design &amp; Digital Experiences', false)
            ->assertSee('og:locale" content="en_US"', false)
            ->assertSee('Your name')->assertSee('Phone number')->assertSee('About your project')
            ->assertSee('Send request')->assertSee('Dark mode')->assertSee('flowseeTranslations', false);
        foreach (['/', '/en'] as $url) {
            $this->get($url)->assertOk()->assertSee('hreflang="fa"', false)->assertSee('hreflang="en"', false);
        }
        $this->get('/product/e-learning')->assertOk()->assertDontSee('hreflang="en"', false)
            ->assertDontSee('/en/product/e-learning', false);
    }

    public function test_untranslated_article_alias_redirects_without_counting_an_extra_view(): void
    {
        $post = $this->publish('language-check');
        $this->get('/en/blog/language-check')->assertStatus(301)->assertRedirect('/blog/language-check');
        $this->assertSame(0, $post->fresh()->views);
        $this->get('/en/blog?category=brand-identity&page=2')->assertStatus(301)
            ->assertRedirect('/blog?category=brand-identity&page=2');
        $this->get('/blog/language-check')->assertOk()->assertDontSee('hreflang="en"', false)
            ->assertSee('og:type" content="article"', false);
    }

    public function test_sitemap_tracks_public_case_studies_and_excludes_drafts_and_redirects(): void
    {
        foreach (['published', 'draft', 'inactive', 'mapi-shop'] as $slug) {
            $project = Project::factory()->create(['slug' => $slug, 'is_active' => $slug !== 'inactive', 'has_case_study' => true]);
            CaseStudy::create(['project_id' => $project->id, 'slug' => $slug, 'title' => $slug, 'is_published' => $slug !== 'draft']);
        }
        $response = $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('https://flowsee.ir/projects/published')->assertSee('https://flowsee.ir/en')
            ->assertSee('https://flowsee.ir/qazvin-beauty')->assertSee('https://flowsee.ir/product/e-learning')
            ->assertDontSee('/projects/draft')->assertDontSee('/projects/inactive')->assertDontSee('/projects/mapi-shop');
        $this->assertNotFalse(simplexml_load_string($response->getContent()));
        $this->get('/en/projects/published')->assertStatus(301)->assertRedirect('/projects/published');
        $this->get('/en/projects/draft')->assertNotFound();
        $this->get('/')->assertOk()->assertSee('/projects/published"', false)->assertDontSee('/projects/draft"', false);
    }

    public function test_landing_page_structured_data_is_json_and_font_preloads_match_the_stylesheet(): void
    {
        $html = $this->get('/qazvin-beauty')->assertOk()->assertDontSee('.ttf', false)->getContent();
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $match);
        $data = json_decode($match[1], true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('Service', $data['@type']);
        $this->assertSame('https://flowsee.ir/qazvin-beauty', $data['url']);
    }

    public function test_article_logos_are_local_and_editor_content_and_unknown_images_remain_intact(): void
    {
        $post = $this->publish('react-guide');
        $original = '<figure><img src="https://cdn.simpleicons.org/react/61dafb" alt="React"></figure><img src="https://example.test/photo.jpg">';
        $post->update(['content' => $original, 'cover_image' => 'https://cdn.simpleicons.org/react/61dafb']);
        $this->get('/blog/react-guide')->assertOk()->assertDontSee('cdn.simpleicons.org', false)
            ->assertSee('/assets/stack-icons/react-')->assertSee('https://example.test/photo.jpg', false)
            ->assertDontSee('og:image:type" content="image/jpeg"', false);
        $this->assertSame($original, $post->fresh()->content);
        foreach (config('website-media.remote_media') as $remote => $local) {
            $this->assertFileExists(public_path($local));
            $this->assertStringEndsWith($local, WebsiteMediaUrl::for($remote));
        }
    }
}
