# پروژه: API رزرو موقت اتاق هتل

**نسخه:** 1.0  
**زبان:** PHP (Laravel)  
**شرح کوتاه:** این پروژه یک API تستی برای رزرو **موقت** اتاق‌های هتل است. کاربر می‌تواند با ارسال `room_id` و `quantity` یک رزرو موقت (اعتبار ۲ دقیقه) ثبت کند؛ در صورت وجود ظرفیت کافی، ظرفیت کاسته می‌شود و پس از انقضا ظرفیت آزاد خواهد شد.

---

## فهرست محتوا
- [ویژگی‌ها](#%D9%88%DB%8C%DA%98%DA%AF%DB%8C%E2%80%8C%D9%87%D8%A7)
- [نیازمندی‌ها](#%D9%86%DB%8C%D8%A7%D8%B2%D9%85%D9%86%D8%AF%DB%8C%E2%80%8C%D9%87%D8%A7)
- [نصب و راه‌اندازی سریع](#%D9%86%D8%B5%D8%A8-%D9%88-%D8%B1%D8%A7%D9%87%E2%80%8C%D8%A7%D9%86%D8%AF%D8%A7%D8%B2%DB%8C-%D8%B3%D8%B1%DB%8C%D8%B9)
- [متغیرهای محیطی مهم (`.env`)](#%D9%85%D8%AA%D8%BA%DB%8C%D8%B1%D9%87%D8%A7%DB%8C-%D9%85%D8%AD%DB%8C%D8%B7%DB%8C-%D9%85%D9%87%D9%85)
- [اجرای مهاجرت‌ها و دادهٔ اولیه](#%D8%A7%D8%AC%D8%B1%D8%A7%DB%8C-%D9%85%D9%87%D8%A7%D8%AC%D8%B1%D8%AA%E2%80%8C%D9%87%D8%A7-%D9%88-%D8%AF%D8%A7%D8%AF%D9%87%E2%80%8C%D8%A7%D9%88%D9%84%DB%8C)
- [اجرای صف‌ها و انقضاها (Expiration)](#%D8%A7%D8%AC%D8%B1%D8%A7%DB%8C-%D8%B5%D9%81%E2%80%8C%D9%87%D8%A7-%D9%88-%D8%A7%D9%86%D9%82%D8%B6%D8%A7%D9%87%E2%80%8C%D9%87%D8%A7)
- [مسیرها / Endpoints همراه مثال‌های درخواست و پاسخ](#%D9%85%D8%B3%DB%8C%D8%B1%D9%87%D8%A7--endpoints-%D9%87%D9%85%D8%B1%D8%A7%D9%87-%D9%85%D8%AB%D8%A7%D9%84%E2%80%8C%D9%87%D8%A7%DB%8C-%D8%AF%D8%B1%D8%AE%D9%88%D8%A7%D8%B3-%D9%88-%D9%BE%D8%A7%D8%B3%D8%AE)
- [مدیریت هم‌زمانی و جلوگیری از oversell](#%D9%85%D8%AF%DB%8C%D8%B1%DB%8C%D8%AA-%D9%87%D9%85%E2%80%8C%D8%B2%D9%85%D8%A7%D9%86%DB%8C-%D9%88-%D8%AC%D9%84%D9%88%DA%AF%DB%8C%D8%B1%DB%8C-%D8%A7%D8%B2-oversell)
- [معماری پروژه (مختصر)](#%D9%85%D8%B9%D9%85%D8%A7%D8%B1%DB%8C-%D9%BE%D8%B1%D9%88%DA%98%D9%87-%D9%85%D8%AE%D8%AA%D8%B5%D8%B1)
- [تست‌ها](#%D8%AA%D8%B3%D8%AA%E2%80%8C%D9%87%D8%A7)
- [موارد امتیازی پیشنهادی](#%D9%85%D9%88%D8%A7%D8%B1%D8%AF-%D8%A7%D9%85%D8%AA%DB%8C%D8%A7%D8%B2%DB%8C)
- [نحوهٔ مشارکت / Contributing](#%D9%86%D8%AD%D9%88%D9%87%E2%80%8C%D9%85%D8%B4%D8%A7%D8%B1%DA%A9%D8%AA--contributing)
- [لایسنس](#%D9%84%D8%A7%DB%8C%D8%B3%D9%86%D8%B3)

---

## ویژگی‌ها
- لیست اتاق‌ها با ظرفیت پیش‌فرض و ظرفیت فعلی.
- رزرو موقت: ثبت رزرو با `room_id` و `quantity`.
- اعتبار رزرو: **۲ دقیقه** (قابل تنظیم).
- کاهش ظرفیت هنگام رزرو و آزادسازی خودکار پس از انقضا.
- پاسخ‌های ساختارمند (JSON) و پیام‌های خطای قابل‌فهم.
- طراحی طبق الگوهای `Repository` و `Service` (قابل توسعه).

---

## نیازمندی‌ها
- PHP >= 8.2  
- Composer  
- Laravel 12.x  
- پایگاه داده (MySQL یا مشابه)  
- Redis یا Queue driver مناسب (برای اجرای Jobها / صف‌ها) — البته می‌توان از `database` queue نیز استفاده کرد.

---

## نصب و راه‌اندازی سریع

1. کلون کردن ریپو:
   ```bash
   git clone https://github.com/AliShabanzade/reservation.git
 
   ```

2. نصب وابستگی‌ها:
   ```bash
   composer install
   npm install
   npm run dev   # در صورت نیاز به assets فرانت
   ```

3. آماده‌سازی فایل محیطی:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   سپس مقادیر اتصال دیتابیس و صف را در `.env` قرار دهید.

4. اجرای مهاجرت‌ها و دادهٔ اولیه:
   ```bash
   php artisan migrate --seed
   ```
   (اگر می‌خواهید دیتابیس را از صفر ریست کنید:)
   ```bash
   php artisan migrate:fresh --seed
   ```

5. اجرای صف‌ها (آیا از Redis یا database استفاده می‌کنید؟)
   - راه سریع (توسعه):
     ```bash
     php artisan queue:work
     ```
   - پیشنهاد برای محصول:
     از یک پروسس منیجر (supervisor) برای اجرای `php artisan queue:work` استفاده کنید.

6. اجرای سرور محلی:
   ```bash
   php artisan serve
   ```
   سپس API معمولاً در `http://127.0.0.1:8000` در دسترس خواهد بود.

---

## متغیرهای مهم در `.env`
```env
APP_NAME=ReservationAPI
APP_ENV=local
APP_KEY=base64:...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reservation
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database   # یا redis
CACHE_DRIVER=file
```

---

## اجرای زمان‌بندی (Scheduler) برای پاکسازی/انقضاها
اگر پروژه از `ExpireReservationsCommand` یا زمان‌بندی برای بررسی انقضاها استفاده می‌کند، بهترین کار اضافه کردن crontab زیر در سرور است:
```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```
بدین شکل کرون هر دقیقه `schedule:run` را اجرا کرده و کامندهای زمان‌بندی‌شده را اجرا می‌کند. (جایگزین: می‌توانید از job/queue مستقیم استفاده کنید.)

---

## Endpoints (نمونه‌ها)

> فرض می‌کنیم پایهٔ آدرس: `http://127.0.0.1:8000/api/v1`

### 1. لیست اتاق‌ها
- **درخواست**
  ```
  GET /api/v1/rooms
  ```
- **پاسخ نمونه**
  ```json
  [
    {
      "id": 1,
      "name": "اتاق یک نفره",
      "capacity": 5,
      "available": 3
    },
    ...
  ]
  ```

### 2. ثبت رزرو موقت
- **درخواست**
  ```
  POST /api/v1/reservations
  Content-Type: application/json

  {
    "room_id": 1,
    "quantity": 2
  }
  ```
- **پاسخ موفق**
  ```json
  {
    "status": "success",
    "data": {
      "reservation_id": 123,
      "room_id": 1,
      "quantity": 2,
      "expires_at": "2025-08-23T12:34:56Z"
    }
  }
  ```
- **پاسخ خطا (ظرفیت ناکافی)**
  ```json
  {
    "status": "error",
    "message": "ظرفیت کافی برای این اتاق وجود ندارد."
  }
  ```

### 3. مشاهده جزئیات رزرو (اختیاری)
- `GET /api/v1/reservations/{id}`

---

## مدیریت هم‌زمانی و جلوگیری از Oversell
برای جلوگیری از oversell و مشکلات رقابتی،:

 **قفل سطح ردیف در تراکنش (Pessimistic Locking)**  
   از `lockForUpdate()` در تراکنش DB استفاده کنید تا هم‌زمان چند درخواست نتوانند ظرفیت را همزمان تغییر دهند:
   ```php
   use Illuminate\Support\Facades\DB;

   DB::transaction(function() use ($roomId, $quantity) {
       $room = Room::where('id', $roomId)->lockForUpdate()->firstOrFail();

       if ($room->available < $quantity) {
           throw new \Exception('Not enough capacity');
       }

       $room->available -= $quantity;
       $room->save();

       // ایجاد رکورد رزرو...
   });
   ```



## معماری پروژه (مختصر)
ساختار (مسیرها در پروژه):
- `app/Http/Controllers/` → کنترلرهای API (`RoomController`, `ReservationController`)
- `app/Domain/Reservations/` → DTOها، Events، Jobs مرتبط با رزرو
- `app/Repositories/` → لایهٔ دسترسی به داده (RoomRepository, ReservationRepository)
- `app/Services/` → منطق اصلی رزرو (ReservationService)
- `app/Console/Commands/ExpireReservationsCommand.php` → کامندی برای پردازش انقضاها
- `app/Domain/Reservations/Jobs/ExpireReservationJob.php` → Job برای آزادسازی ظرفیت

(در ریپو شما همین الگوها به‌صورت تفکیک‌شده قرار دارند؛ این ساختار باعث خوانایی و قابل‌تست بودن بهتر می‌شود.)

---

## تست‌ها
- تست‌ها در فولدر `tests/` قرار دارند.  
- اجرای تست‌ها:
  ```bash
  php artisan test
  ```
- پیشنهاد: نوشتن تست‌های واحد برای منطق کاهش/آزادسازی ظرفیت و تست‌های یکپارچه (integration) که رقابت هم‌زمان را شبیه‌سازی کنند.

---





## نکات عملیاتی
- برای محیط تولید حتماً از `QUEUE_CONNECTION=redis` یا یک صف‌Runner با supervisor استفاده کنید.
- مطمئن شوید زمان سرور (timezone) با زمان ذخیره‌شده در `expires_at` هماهنگ است (UTC توصیه می‌شود).
- هنگام تست concurrency از ابزارهایی مثل `ab`, `wrk` یا اسکریپت‌های php/curl موازی استفاده کنید.

---


---

## مشارکت (Contributing)
1. Fork کنید.
2. یک branch جدید بسازید (`feature/your-feature`).
3. تغییرات را کامیت کرده و pull request ارسال کنید.
4. قبل از PR، `php artisan test` را اجرا کنید تا همه تست‌ها پاس شوند.

---

## لایسنس
این پروژه با لایسنس MIT منتشر شود (در صورت تمایل، فایل `LICENSE` اضافه کنید).

---

## تماس / پشتیبانی
برای سوالات بیشتر یا بازبینی کد، می‌توانید issue باز کنید یا PR ارسال کنید.
