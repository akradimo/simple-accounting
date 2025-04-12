<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

تحلیل وضعیت فعلی پروژه:
1. مهاجرت‌های انجام شده:
[✓] users - جدول کاربران سیستم
[✓] accounts - جدول حساب‌های مالی
[✓] transactions - جدول تراکنش‌ها
[✓] people - جدول اشخاص
[✓] products - جدول کالاها
[✓] services - جدول خدمات
[✓] banks - جدول بانک‌ها
[✓] cashboxes - جدول صندوق‌ها
[✓] sales و sale_items - جداول فروش
[✓] purchases و purchase_items - جداول خرید
2. مدل‌های ایجاد شده:
[✓] User.php
[✓] Account.php - با روابط transactions
[✓] Transaction.php - با روابط morphable
[✓] Person.php - با روابط sales و purchases
[✓] Product.php - با مدیریت موجودی
[✓] Service.php - با محاسبات قیمت
[✓] Bank.php - با مدیریت تراکنش‌ها
[✓] Cashbox.php - با کنترل موجودی
[✓] Sale.php و SaleItem.php - با محاسبات فاکتور
[✓] Purchase.php و PurchaseItem.php - با مدیریت خرید
3. کنترلرهای موجود:
[✓] HomeController.php
[✓] PersonController.php
[✓] PaymentController.php
[✓] ExpenseController.php
[✓] ProductController.php
[✓] ServiceController.php
[✓] BankController.php
[✓] CashboxController.php
[✓] AccountingController.php
[✓] ReportController.php
[✓] SettingController.php
4. مسیرها (Routes):
[✓] تمام مسیرها در web.php تعریف شده‌اند
[✓] Authentication routes
[✓] Resource routes برای تمام بخش‌ها
[✓] Routes گروه‌بندی شده برای بخش‌های مختلف
5. نماها (Views):
[✓] layouts/app.blade.php - قالب اصلی
[✓] layouts/sidebar.blade.php - منوی کناری
[✓] dashboard.blade.php - صفحه داشبورد
[÷] فرم‌های ورود اطلاعات (نیمه‌تمام)
[÷] صفحات لیست (نیمه‌تمام)
6. Assets:
[✓] AdminLTE templates
[✓] Custom CSS files
[✓] Custom JavaScript files
[✓] Font files
7. مشکلات فعلی:
سایدبار:

زیرمنوها به درستی باز نمی‌شوند
نیاز به اصلاح JavaScript
داشبورد:

نیاز به استایل‌های CSS
نیاز به اصلاح چارت‌ها
فرم‌ها:

نیاز به validation
نیاز به اصلاح UX/UI
گزارش‌ها:

نیاز به پیاده‌سازی کامل
نیاز به اضافه کردن فیلترها
نقشه راه پیشنهادی:
اولویت اول:

اصلاح سایدبار و منوها
تکمیل استایل‌های داشبورد
پیاده‌سازی validation فرم‌ها
اولویت دوم:

تکمیل فرم‌های ورود اطلاعات
پیاده‌سازی CRUD کامل
اضافه کردن سیستم اعلان‌ها
اولویت سوم:

پیاده‌سازی کامل گزارش‌ها
اضافه کردن نمودارها
بهینه‌سازی کوئری‌ها
اولویت چهارم:

اضافه کردن سیستم بک‌آپ
پیاده‌سازی API
مستندسازی
آیا مایلید روی کدام بخش از این موارد کار کنیم؟


سایدبار 
- داشبورد
- اشخاص
  ├─ شخص جدید
  ├─ اشخاص
  ├─ دریافت
  ├─ لیست دریافت ها
  ├─ پرداخت
  ├─ لیست پرداخت ها
  ├─ سهامداران
  └─ فروشندگان
- کالاها و خدمات
  ├─ کالای جدید
  ├─ خدمات جدید
  ├─ کالاها و خدمات
  ├─ به روز رسانی لیست قیمت
  ├─ چاپ بارکد
  ├─ چاپ بارکد تعدادی
  └─ صفحه لیست قیمت کالا
- بانکداری
  ├─ بانک‌ها
  ├─ صندوق‌ها
  ├─ تنخواه‌گردان‌ها
  ├─ انتقال
  ├─ لیست انتقال‌ها
  ├─ لیست چک‌های دریافتی
  └─ لیست چک‌های پرداختی
- فروش و درآمد
  ├─ فروش جدید
  ├─ فاکتور سریع
  ├─ برگشت از فروش
  ├─ فاکتورهای فروش
  ├─ فاکتورهای برگشت از فروش
  ├─ درآمد
  ├─ لیست درآمدها
  ├─ قرارداد فروش اقساطی
  ├─ لیست فروش اقساطی
  └─ اقلام تخفیف دار
- خرید و هزینه
  ├─ خرید جدید
  ├─ برگشت از خرید
  ├─ فاکتورهای خرید
  ├─ فاکتورهای برگشت از خرید
  ├─ هزینه
  ├─ لیست هزینه‌ها
  ├─ ضایعات
  └─ لیست ضایعات
- انبارداری
  ├─ انبارها
  ├─ حواله جدید
  ├─ رسید و حواله‌های انبار
  ├─ موجودی کالا
  ├─ موجودی تمامی انبارها
  └─ انبارگردانی
- حسابداری
  ├─ سند جدید
  ├─ لیست اسناد
  ├─ تراز افتتاحیه
  ├─ بستن سال مالی
  ├─ جدول حساب‌ها
  └─ تجمیع اسناد
- سایر
  ├─ آرشیو
  ├─ پنل پیامک
  ├─ استعلام
  ├─ دریافت سایر
  ├─ لیست دریافت‌ها
  ├─ پرداخت سایر
  ├─ لیست پرداخت‌ها
  ├─ سند تسعیر ارز
  ├─ سند توازن اشخاص
  ├─ سند توازن کالاها
  └─ سند حقوق
- گزارش‌ها
  ├─ تمام گزارش‌ها
  ├─ ترازنامه
  ├─ بدهکاران و بستانکاران
  ├─ کارت حساب اشخاص
  ├─ کارت حساب کالا
  ├─ فروش به تفکیک کالا
  └─ کارت پروژه
- تنظیمات
  ├─ پروژه‌ها
  ├─ اطلاعات کسب و کار
  ├─ تنظیمات مالی
  ├─ جدول تبدیل نرخ ارز
  ├─ مدیریت کاربران
  ├─ تنظیمات چاپ
  ├─ فرم ساز
  └─ اعلانات