<?php

namespace App\Jobs;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendLeadNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public int $leadId;

    public int $tries = 3;

    public array $backoff = [10, 30, 60];

    /**
     * Telegram rejects sendMessage requests with more than 4096 characters
     * with a 400 Bad Request error.
     */
    protected const TELEGRAM_MESSAGE_LIMIT = 4096;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }

    public function handle(): void
    {
        $lead = Lead::find($this->leadId);

        if (! $lead) {
            return;
        }

        $message = $this->formatMessage($lead);

        $sent = $this->sendToTelegram($message);

        if ($sent) {
            Log::channel('lead_notifications')->info('Lead notification sent to Telegram', [
                'lead_id' => $lead->id,
                'name' => $lead->name,
                'phone' => $lead->phone,
                'service' => $lead->service,
            ]);
        } else {
            Log::channel('lead_notifications')->error('Failed to send lead notification to Telegram', [
                'lead_id' => $lead->id,
                'name' => $lead->name,
            ]);
        }
    }

    /**
     * Build the structured Telegram message.
     *
     * Telegram parses the text as HTML, so every user supplied value must be
     * escaped. Otherwise an incomplete tag or a stray "<" / ">" / "&" breaks the
     * document and the Bot API answers with 400 Bad Request.
     */
    protected function formatMessage(Lead $lead): string
    {
        $serviceLabel = e(Lead::SERVICES[$lead->service] ?? $lead->service);

        $header = "🔔 <b>درخواست جدید</b>\n\n"
            . "👤 <b>نام:</b> " . e($lead->name) . "\n"
            . "📞 <b>تلفن:</b> <code>" . e($lead->phone) . "</code>\n"
            . "📧 <b>ایمیل:</b> " . ($lead->email ? "<code>" . e($lead->email) . "</code>" : '—') . "\n"
            . "🛠 <b>خدمت:</b> {$serviceLabel}\n"
            . "📝 <b>توضیحات:</b>\n";

        $details = $this->truncateDetailsToTelegramLimit(
            $lead->details ?: '—',
            self::TELEGRAM_MESSAGE_LIMIT - mb_strlen($header) - 1
        );

        return $header . e($details);
    }

    /**
     * Shrink the raw details so the escaped message stays within Telegram's
     * 4096 character limit. The value is trimmed before it is escaped, which
     * guarantees we never cut through an HTML tag or entity.
     */
    protected function truncateDetailsToTelegramLimit(string $details, int $limit): string
    {
        if ($limit <= 0) {
            return '';
        }

        if (mb_strlen(e($details)) <= $limit) {
            return $details;
        }

        while ($details !== '' && mb_strlen(e($details)) > $limit) {
            $details = mb_substr($details, 0, (int) floor(mb_strlen($details) * 0.75));
        }

        return $details;
    }

    protected function sendToTelegram(string $message): bool
    {
        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (! $botToken || ! $chatId) {
            Log::channel('lead_notifications')->warning('Telegram not configured, skipping notification', [
                'lead_id' => $this->leadId,
            ]);
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::channel('lead_notifications')->error('Telegram API exception', [
                'lead_id' => $this->leadId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
