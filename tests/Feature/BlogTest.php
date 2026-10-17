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
        $this->get('/blog')->assertOk()->assertSee('مقاله‌ها و راهنماها')->assertSee('راهنمای ساخت هویت برند')->assertDontSee('پیش‌نویس خصوصی');
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

//lol
