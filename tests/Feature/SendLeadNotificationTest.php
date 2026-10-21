<?php

namespace Tests\Feature;

use App\Jobs\SendLeadNotification;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SendLeadNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.telegram.bot_token' => 'test-bot-token',
            'services.telegram.chat_id' => 'test-chat-id',
        ]);
    }

    /**
     * Simulate the Telegram Bot API HTML parser: any raw "<" that is not one of
     * the tags we intentionally emit (b, code) or a "><" pair makes the request
     * invalid and the API answers with 400 Bad Request.
     */
    protected function fakeTelegramApi(): void
    {
        Http::fake(function ($request) {
            // The client sends JSON, so inspect the decoded text Telegram receives.
            $payload = json_decode($request->body(), true);
            $text = (string) ($payload['text'] ?? '');

            $hasRawTag = preg_match('#<(?!/?(?:b|code)>)#', $text) === 1;
            $hasRawChevronPair = str_contains($text, '><');

            if ($hasRawTag || $hasRawChevronPair) {
                return Http::response([
                    'ok' => false,
                    'error_code' => 400,
                    'description' => "Bad Request: can't parse entities: Character '<' is a reserved character. BODY=".$text,
                ], 400);
            }

            return Http::response([
                'ok' => true,
                'result' => ['message_id' => 1],
            ], 200);
        });
    }

    public function test_it_escapes_special_characters_before_sending_to_telegram(): void
    {
        $this->fakeTelegramApi();

        $lead = Lead::factory()->create([
            'name' => 'علی <script>alert(1)</script> & شرکت',
            'email' => 'ali<script>&test@example.com',
            'details' => 'پروژه <b>تست</b> با & و >< و <script> و "کوتیشن"',
        ]);

        (new SendLeadNotification($lead->id))->handle();

        Http::assertSent(function ($request) {
            $text = (string) $request->data()['text'];

            // User supplied markup must be neutralised.
            $this->assertStringContainsString('&lt;script&gt;', $text);
            $this->assertStringContainsString('&amp;', $text);
            $this->assertStringContainsString('&gt;&lt;', $text);
            $this->assertStringNotContainsString('<script>', $text);
            $this->assertStringNotContainsString('><', $text);

            // The tags we intentionally use are still present.
            $this->assertStringContainsString('<b>درخواست جدید</b>', $text);
            $this->assertStringContainsString('<code>', $text);

            return true;
        });

        // The fake returns 400 for any unescaped markup; reaching a 200 response
        // proves Telegram accepted the payload (no 400 Bad Request).
        $response = Http::recorded()->first()[1] ?? null;

        $this->assertNotNull($response, 'The notification was not sent to Telegram.');
        $this->assertSame(200, $response->status(), 'Telegram rejected the message: '.$response->body());
    }

    public function test_it_keeps_long_messages_under_the_telegram_character_limit(): void
    {
        $this->fakeTelegramApi();

        $lead = Lead::factory()->create([
            'details' => str_repeat('a', 6000) . str_repeat('<', 500),
        ]);

        (new SendLeadNotification($lead->id))->handle();

        Http::assertSent(function ($request) {
            $text = (string) $request->data()['text'];

            $this->assertLessThanOrEqual(4096, mb_strlen($text));

            return true;
        });
    }
}
