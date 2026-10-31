<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendLeadNotification;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $phone = (string) $request->input('phone', '');
        $phone = strtr($phone, [
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
            '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
            '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
        ]);
        $phone = preg_replace('/[\s()\-]+/u', '', $phone) ?? $phone;
        $request->merge(['phone' => $phone]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^(\+98|0098|0)?9\d{9}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'service' => ['required', 'string', 'max:50'],
            'details' => ['required', 'string', 'max:5000'],
            'campaign_key' => ['nullable', 'string', 'max:80'],
            'store_identifier' => ['nullable', 'string', 'max:100'],
            'utm_source' => ['nullable', 'string', 'max:160'],
            'utm_medium' => ['nullable', 'string', 'max:160'],
            'utm_campaign' => ['nullable', 'string', 'max:160'],
            'landing_path' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'نام خود را وارد کنید.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.',
            'phone.required' => 'شمارهٔ تماس را وارد کنید.',
            'phone.regex' => 'شمارهٔ تماس معتبر وارد کنید؛ مثلاً ۰۹۱۲۳۴۵۶۷۸۹.',
            'email.email' => 'ایمیل را به شکل name@example.com وارد کنید.',
            'service.required' => 'خدمت موردنظر را انتخاب کنید.',
            'details.required' => 'توضیح کوتاهی دربارهٔ پروژه بنویسید.',
            'details.max' => 'توضیحات نمی‌تواند بیشتر از ۵۰۰۰ کاراکتر باشد.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'لطفاً فیلدهای مشخص‌شده را اصلاح کنید.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $leadData = $validator->validated();
        $campaignKey = $leadData['campaign_key'] ?? null;
        $details = $leadData['details'];
        if ($campaignKey) {
            $attribution = collect([
                'utm_source' => $leadData['utm_source'] ?? null,
                'utm_medium' => $leadData['utm_medium'] ?? null,
                'utm_campaign' => $leadData['utm_campaign'] ?? null,
                'landing_path' => $leadData['landing_path'] ?? null,
            ])->filter(fn (?string $value): bool => filled($value))
                ->map(fn (string $value, string $key): string => $key.'='.$value)
                ->implode("\n");
            if ($attribution !== '') {
                $details .= "\n\nاطلاعات ورودی کمپین:\n".$attribution;
            }
        }

        $lead = Lead::create([
            'name' => $leadData['name'],
            'phone' => $leadData['phone'],
            'email' => $leadData['email'] ?? null,
            'service' => $leadData['service'],
            'details' => $details,
            'campaign_key' => $campaignKey,
            'store_identifier' => $leadData['store_identifier'] ?? null,
            'utm_source' => $leadData['utm_source'] ?? null,
            'utm_medium' => $leadData['utm_medium'] ?? null,
            'utm_campaign' => $leadData['utm_campaign'] ?? null,
            'landing_path' => $leadData['landing_path'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if (! app()->environment('testing')) {
            try {
                SendLeadNotification::dispatch($lead->id);
            } catch (\Throwable $queueException) {
                Log::channel('lead_notifications')->warning('Could not queue lead notification; trying inline delivery.', [
                    'lead_id' => $lead->id,
                    'exception' => $queueException::class,
                ]);

                try {
                    SendLeadNotification::dispatchSync($lead->id);
                } catch (\Throwable $fallbackException) {
                    Log::channel('lead_notifications')->error('Inline lead notification failed.', [
                        'lead_id' => $lead->id,
                        'exception' => $fallbackException::class,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'اطلاعات شما با موفقیت ثبت شد. به‌زودی با شما تماس می‌گیریم.',
            'data' => [
                'id' => $lead->id,
            ],
        ], Response::HTTP_OK);
    }
}
