<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    public const STATUSES = [
        'new' => 'جدید',
        'contacted' => 'تماس‌گرفته‌شده',
        'negotiating' => 'در حال مذاکره',
        'archived' => 'بایگانی',
    ];

    public const SERVICES = [
        'branding' => 'طراحی هویت بصری',
        'marketing' => 'دیجیتال مارکتینگ',
        'uiux' => 'طراحی رابط و تجربه کاربری',
        'packaging' => 'بسته‌بندی محصول',
        'video' => 'تولید محتوای تبلیغاتی',
        'academy' => 'توسعه سرمایه انسانی',
        'consultation' => 'مشاوره',
    ];

    protected $fillable = [
        'name',
        'phone',
        'email',
        'service',
        'details',
        'ip_address',
        'user_agent',
        'is_read',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }
}
