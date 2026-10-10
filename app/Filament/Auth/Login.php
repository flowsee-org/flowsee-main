<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as FilamentLogin;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class Login extends FilamentLogin
{
    protected function throwFailureValidationException(): never
    {
        $message = 'ورود انجام نشد. ایمیل یا گذرواژه نادرست است، یا این حساب دسترسی مدیر ندارد.';

        Notification::make()
            ->title('ورود ناموفق بود')
            ->body($message)
            ->danger()
            ->send();

        throw ValidationException::withMessages([
            'data.email' => $message,
        ]);
    }
}
