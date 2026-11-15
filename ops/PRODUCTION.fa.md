# نگهداری نسخهٔ production فلوسی

## مسیرهای ثابت

| مسیر | کاربرد |
| --- | --- |
| `/var/www/flowsee-main` | کد Git سایت؛ اجرای Artisan در این پوشه الزاماً به دیتابیس فعال وصل نمی‌شود. |
| `/var/www/flowsee-live` | پیوند به پوشهٔ public نسخهٔ فعال سایت |
| `/var/www/flowsee-releases` | نسخه‌های منتشرشده؛ ویرایش دستی در این پوشه‌ها با انتشار بعدی از دست می‌رود. |
| `/var/www/flowsee-shared/.env` | تنظیمات production سایت |
| `/var/www/flowsee-shared/database/database.sqlite` | دیتابیس فعلی سایت |
| `/var/www/flowsee-shared/storage` | فایل‌ها، لاگ‌ها و کش مشترک سایت |
| `/opt/flowsee-deploy/deploy.py` | اسکریپت نصب‌شدهٔ انتشار که webhook اجرا می‌کند |
| `/var/www/flowsee-studio` | برنامهٔ React و Node استودیو |

تغییر `APP_ENV` در checkout مسیر دیتابیس یا نسخهٔ سایت را عوض نمی‌کند. تنظیمات فعال را از Laravel بوت‌شده در release بررسی کنید؛ پیکربندی می‌تواند cache شده باشد.

## انتشار عادی

تغییر را در GitHub ادغام کنید و نتیجهٔ گردش‌کار **Deploy to Server** را بررسی کنید.
این فرایند migration و seederهای اختصاصی را با PHP 8.4 و محیط shared اجرا می‌کند.
برای انتشار عادی به اجرای دستی Composer، migrate یا db:seed در checkout نیازی نیست.

اسکریپت نصب‌شدهٔ `/opt` با فایل `ops/deploy.py` در مخزن جداست. تغییرات خود اسکریپت باید پیش از تکیه بر رفتار جدید آن، به نسخهٔ نصب‌شده منتقل شوند؛ git pull به‌تنهایی آن فایل را عوض نمی‌کند. هنگام انتقال از نسخهٔ قبلی پشتیبان بگیرید.

## بررسی بدون تغییر داده

این فرمان‌ها از هر پوشه‌ای قابل اجرا هستند:

```bash
readlink -f /var/www/flowsee-live
curl -sS -o /dev/null -w 'HTTP %{http_code}\n' https://flowsee.ir/
curl -fsS https://flowsee.ir/deployment.txt
grep -E 'production\.ERROR' /var/www/flowsee-shared/storage/logs/laravel.log | tail -n 3
```

HTTP 200 فقط موفقیت همان درخواست را نشان می‌دهد. زمان پیام لاگ را با زمان درخواست مقایسه کنید؛ خطاهای قدیمی در فایل باقی می‌مانند. سلامت صفحهٔ اصلی، بلاگ و مقاله باید جدا بررسی شود.

برای وضعیت migrationها:

```bash
cd "$(dirname "$(readlink -f /var/www/flowsee-live)")" || exit
runuser -u www-data -- /usr/bin/php8.4 artisan migrate:status
```

## خطای خدمات صفحهٔ اصلی

در نسخه‌های قدیمی، کش `flowsee.home.services` بدون بررسی نوع به قالب داده می‌شد. مقدار متنی ناسازگار می‌تواند خطای `Attempt to read property "is_highlighted" on string` بدهد.
نسخهٔ اصلاح‌شده فهرست خدمات را مستقیم از دیتابیس می‌خواند.
تا پیش از انتشار اصلاح، فقط همان کلید را حذف کنید:

```bash
cd "$(dirname "$(readlink -f /var/www/flowsee-live)")" || exit
runuser -u www-data -- /usr/bin/php8.4 artisan cache:forget flowsee.home.services
```

## داده‌های سایت و استودیو

مقاله‌ها، نمونه‌کارها و پیام‌های سایت در دیتابیس Laravel هستند.
بخش‌های مدیریت سایت در استودیو از API سایت اصلی استفاده می‌کنند؛ از جمله
`https://flowsee.ir/api/studio/site-content/blog`.
داده‌های داخلی کاربران و تسک‌های استودیو در backend همان برنامه ذخیره می‌شوند؛ فایل JSON استودیو، فایل SQLite سایت نیست.

`VITE_MAIN_API_URL=https://flowsee.ir` تنظیم زمان build استودیو است.
نوشتن آن در ترمینال به‌تنهایی فایل `.env` را ذخیره نمی‌کند. فایل‌های محیطی و داده‌های واقعی را وارد Git نکنید و در گفتگو منتشر نکنید.

## فرمان‌های تغییر داده

`php artisan db:seed` بدون class در این مخزن، DatabaseSeeder را اجرا می‌کند که رکوردهای موجود سایت و لیدها را پاک می‌کند؛ روی production اجرا نشود.
Seeder مقاله‌ها با نام `ProgrammingStackArticlesSeeder` مشخص است، اما اجرای دوبارهٔ آن مقاله‌های هم‌نام را به متن seed برمی‌گرداند. برای ویرایش روزمرهٔ مقاله‌ها از پنل استودیو استفاده کنید.
