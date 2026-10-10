<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFlowseeAdmin extends Command
{
    protected $signature = 'flowsee:admin:create';

    protected $description = 'Create or update an administrator account for the Flowsee panel';

    public function handle(): int
    {
        $name = trim((string) $this->ask('نام مدیر'));
        $email = mb_strtolower(trim((string) $this->ask('ایمیل ورود')));

        if ($name === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->components->error('نام و ایمیل معتبر لازم است.');

            return self::FAILURE;
        }

        $password = (string) $this->secret('گذرواژه (حداقل ۱۴ نویسه)');
        $confirmation = (string) $this->secret('تکرار گذرواژه');

        if (mb_strlen($password) < 14 || ! hash_equals($password, $confirmation)) {
            $this->components->error('گذرواژه باید دست‌کم ۱۴ نویسه باشد و با تکرار آن یکسان باشد.');

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password), 'is_admin' => true],
        );

        $this->components->info('حساب مدیر ساخته یا به‌روزرسانی شد.');

        return self::SUCCESS;
    }
}
