<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_editorial_lists_are_scoped_and_popularity_uses_actual_article_requests(): void
    {
        $category = BlogCategory::where('slug', 'brand-identity')->firstOrFail();
        $post = BlogPost::create(['blog_category_id' => $category->id, 'title' => 'Selected story', 'slug' => 'selected-story', 'content' => '<p>Story</p>', 'is_featured' => true, 'is_published' => true, 'published_at' => now()->subDay()]);
        $this->getJson('/api/blog?category=brand-identity')->assertOk()->assertJsonCount(0, 'popular')->assertJsonPath('featured.0.id', $post->id);
        $this->get('/blog/selected-story')->assertOk();
        $this->assertSame(1, (int) $post->fresh()->views);
        $this->getJson('/api/blog?category=brand-identity')->assertOk()->assertJsonPath('popular.0.id', $post->id)->assertJsonPath('latest.0.id', $post->id);
        $this->getJson('/api/blog?category=ux-ui')->assertOk()->assertJsonCount(0, 'popular')->assertJsonCount(0, 'featured');
    }

    public function test_public_next_listing_filters_and_paginates_without_exposing_unpublished_content(): void
    {
        $brand = BlogCategory::where('slug', 'brand-identity')->firstOrFail();
        $ux = BlogCategory::where('slug', 'ux-ui')->firstOrFail();
        foreach (range(1, 10) as $index) {
            BlogPost::create([
                'blog_category_id' => $brand->id, 'title' => 'Brand '.$index, 'slug' => 'brand-'.$index,
                'content' => '<p>Full article body should not be in the listing.</p>',
                'cover_image' => 'case-studies/cover.webp', 'is_published' => true, 'published_at' => now()->subDay(),
            ]);
        }
        BlogPost::create(['blog_category_id' => $ux->id, 'title' => 'UX article', 'slug' => 'ux-article', 'content' => 'UX body', 'is_published' => true, 'published_at' => now()->subDay()]);
        BlogPost::create(['blog_category_id' => $brand->id, 'title' => 'Private draft', 'slug' => 'private-draft', 'content' => 'Private body', 'is_published' => false]);
        BlogPost::create(['blog_category_id' => $brand->id, 'title' => 'Scheduled article', 'slug' => 'scheduled-post', 'content' => 'Scheduled body', 'is_published' => true, 'published_at' => now()->addDay()]);

        $this->getJson('/api/blog')->assertOk()->assertJsonPath('pagination.total', 11)->assertJsonCount(9, 'posts')
            ->assertDontSee('Private body')->assertDontSee('private-draft')->assertDontSee('scheduled-post')->assertDontSee('Full article body');
        $first = $this->getJson('/api/blog?category=brand-identity')->assertOk()
            ->assertJsonPath('category.slug', 'brand-identity')->assertJsonPath('pagination.total', 10)->assertJsonPath('pagination.lastPage', 2);
        $second = $this->getJson('/api/blog?category=brand-identity&page=2')->assertOk()->assertJsonCount(1, 'posts');
        $this->assertEmpty(array_intersect(array_column($first->json('posts'), 'id'), array_column($second->json('posts'), 'id')));
        $this->getJson('/api/blog?category=ux-ui')->assertOk()->assertJsonCount(1, 'posts')->assertJsonPath('posts.0.slug', 'ux-article');
        $this->getJson('/api/blog?category=unknown')->assertNotFound();
        $this->getJson('/api/blog?page=0')->assertUnprocessable();
    }

    public function test_homepage_and_blog_pages_render_published_posts_and_category_filters(): void
    {
        $category = BlogCategory::query()->where('slug', 'brand-identity')->firstOrFail();
        $post = BlogPost::create([
            'blog_category_id' => $category->id,
            'title' => 'راهنمای ساخت هویت برند',
            'slug' => 'brand-identity-guide',
            'excerpt' => 'یک راهنمای کاربردی برای شروع.',
            'content' => '<h2>از کجا شروع کنیم؟</h2><p>شناخت مخاطب و جایگاه برند.</p>',
            'cover_image' => 'case-studies/blog-cover.webp',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);
        BlogPost::create([
            'blog_category_id' => $category->id,
            'title' => 'پیش‌نویس خصوصی',
            'slug' => 'private-draft',
            'content' => '<p>نمایش داده نشود</p>',
            'is_published' => false,
        ]);

        $this->get('/')->assertOk()->assertSee('ایده‌هایی برای رشد بهتر.')->assertSee('راهنمای ساخت هویت برند');
        $this->get('/blog')->assertOk()->assertSee('مجلهٔ فلوسی')->assertSee('blog-bento')->assertDontSee('class="blog-hero', false)->assertSee('راهنمای ساخت هویت برند')->assertDontSee('پیش‌نویس خصوصی');
        $this->get('/blog?category=brand-identity')->assertOk()->assertSee('برندینگ و هویت بصری');
        $this->get('/blog/'.$post->slug)->assertOk()
            ->assertSee('<h2>از کجا شروع کنیم؟</h2>', false)
            ->assertSee('BlogPosting', false)
            ->assertSee('راهنمای ساخت هویت برند');
        $this->get('/blog/private-draft')->assertNotFound();
        $this->get('/blog-sitemap.xml')->assertOk()->assertSee('brand-identity-guide')->assertDontSee('private-draft');
    }

    public function test_primary_studio_admin_can_create_and_edit_sanitized_blog_posts(): void
    {
        Http::fake([
            'studio.flowsee.ir/*' => Http::response([
                'id' => 'ceo-1',
                'email' => 'ceo@flowsee.local',
                'role' => 'superadmin',
            ]),
        ]);
        $category = BlogCategory::query()->firstOrFail();

        $response = $this->withToken('primary-admin-session')->postJson('/api/studio/site-content/blog', [
            'blog_category_id' => $category->id,
            'title' => 'مقالهٔ آزمایشی',
            'slug' => 'blog-test-article',
            'excerpt' => 'خلاصهٔ تست',
            'content' => '<h2>شروع</h2><p>متن امن<script>alert(1)</script></p>',
            'cover_image' => 'case-studies/test.webp',
            'cover_alt' => 'تصویر مقاله',
            'is_featured' => true,
            'is_published' => true,
        ])->assertCreated()->assertJsonPath('post.title', 'مقالهٔ آزمایشی');

        $postId = $response->json('post.id');
        $this->assertDatabaseHas('blog_posts', ['id' => $postId, 'is_published' => true]);
        $this->assertSame('<h2>شروع</h2><p>متن امن</p>', $response->json('post.content'));

        $this->putJson('/api/studio/site-content/blog/'.$postId, [
            'blog_category_id' => $category->id,
            'title' => 'عنوان اصلاح‌شده',
            'slug' => 'blog-test-article',
            'content' => '<p>نسخهٔ جدید</p>',
            'cover_image' => 'case-studies/test.webp',
            'is_featured' => false,
            'is_published' => false,
        ])->assertOk()->assertJsonPath('post.title', 'عنوان اصلاح‌شده');
        $this->assertDatabaseHas('blog_posts', ['id' => $postId, 'is_published' => false]);

        $this->deleteJson('/api/studio/site-content/blog/'.$postId)->assertOk();
        $this->assertDatabaseMissing('blog_posts', ['id' => $postId]);
    }
}

