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

    protected function formatMessage(Lead $lead): string
    {
        $serviceLabel = Lead::SERVICES[$lead->service] ?? $lead->service;

        return "🔔 <b>درخواست جدید</b>\n\n"
            . "👤 <b>نام:</b> {$lead->name}\n"
            . "📞 <b>تلفن:</b> <code>{$lead->phone}</code>\n"
            . "📧 <b>ایمیل:</b> " . ($lead->email ? "<code>{$lead->email}</code>" : '—') . "\n"
            . "🛠 <b>خدمت:</b> {$serviceLabel}\n"
            . "📝 <b>توضیحات:</b>\n" . ($lead->details ?: '—');
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
