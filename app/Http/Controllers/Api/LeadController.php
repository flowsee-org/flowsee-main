<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class LeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^(\+98|0098|0)?9\d{9}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'service' => ['required', 'string', 'max:50'],
            'details' => ['required', 'string', 'max:5000'],
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

        $lead = Lead::create([
            'name' => $validator->validated()['name'],
            'phone' => $validator->validated()['phone'],
            'email' => $validator->validated()['email'] ?? null,
            'service' => $validator->validated()['service'],
            'details' => $validator->validated()['details'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'اطلاعات شما با موفقیت ثبت شد. به‌زودی با شما تماس می‌گیریم.',
            'data' => [
                'id' => $lead->id,
            ],
        ], Response::HTTP_OK);
    }
}
