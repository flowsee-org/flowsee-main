<?php

namespace Tests\Unit;

use App\Support\RichTextContent;
use PHPUnit\Framework\TestCase;

class RichTextContentTest extends TestCase
{
    public function test_case_study_serialization_sanitizes_existing_and_new_rich_fields(): void
    {
        foreach ([[new \App\Models\CaseStudy, 'lead'], [new \App\Models\CaseStudySection, 'lead'], [new \App\Models\CaseStudyStep, 'description']] as [$model, $field]) {
            $model->setRawAttributes([$field => '<p>Existing <strong>content</strong></p><script>alert(1)</script>']);
            $this->assertSame('<p>Existing <strong>content</strong></p>', $model->toArray()[$field]);
            $model->$field = '<p>New</p><img src="javascript:alert(1)" onerror="alert(1)">';
            $this->assertStringNotContainsString('javascript', $model->getAttributes()[$field]);
            $this->assertStringNotContainsString('onerror', $model->toArray()[$field]);
        }
    }

    public function test_editor_images_tables_and_alignment_survive_sanitizing(): void
    {
        $html = RichTextContent::sanitize('<h2 style="text-align: center">عنوان</h2><img src="https://flowsee.ir/storage/test.webp" alt="تصویر"><table><tbody><tr><th colspan="2">Title</th></tr><tr><td>A</td><td>B</td></tr></tbody></table>');
        $this->assertStringContainsString('text-align: center', $html);
        $this->assertStringContainsString('alt="تصویر"', $html);
        $this->assertStringContainsString('<table>', $html);
        $this->assertStringContainsString('colspan="2"', $html);
    }

    public function test_unsafe_urls_events_and_styles_are_removed(): void
    {
        $html = RichTextContent::sanitize('<img src="javascript:alert(1)" onerror="alert(1)"><img src="data:image/svg+xml,test"><p style="background:url(https://evil.test)">Safe</p><iframe src="https://evil.test"></iframe><td colspan="900">Cell</td>');
        foreach (['javascript:', 'onerror', 'data:', 'background:', 'iframe', 'colspan'] as $unsafe) {
            $this->assertStringNotContainsString($unsafe, $html);
        }
    }
}
