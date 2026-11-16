<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Database\Seeders\ProgrammingStackArticlesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StackPublicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_repeated_deployment_preserves_editor_content_dates_and_unpublished_guides(): void
    {
        $this->seed(ProgrammingStackArticlesSeeder::class);
        $post = BlogPost::where('slug', 'javascript-guide')->firstOrFail();
        $post->update(['content' => '<p>Editor revised article.</p>', 'meta_title' => 'Editor title']);
        $publishedAt = $post->getRawOriginal('published_at');
        $draft = BlogPost::where('slug', 'php-guide')->firstOrFail();
        $draft->update(['is_published' => false]);
        $post->category->update(['description' => 'Editor category description']);

        $this->travel(2)->days();
        $this->seed(ProgrammingStackArticlesSeeder::class);

        $this->assertSame('<p>Editor revised article.</p>', $post->fresh()->content);
        $this->assertSame('Editor title', $post->fresh()->meta_title);
        $this->assertSame($publishedAt, $post->fresh()->getRawOriginal('published_at'));
        $this->assertFalse($draft->fresh()->is_published);
        $this->assertSame('Editor category description', $post->category->fresh()->description);
        $this->assertSame(14, BlogPost::where('blog_category_id', $post->blog_category_id)->count());
        $figma = BlogPost::where('slug', 'figma-guide')->firstOrFail();
        $this->assertSame('assets/blog-stack-covers/figma-guide.webp', $figma->cover_image);
        $this->assertStringContainsString('ساختار صفحه‌ها', $figma->content);
    }
}
