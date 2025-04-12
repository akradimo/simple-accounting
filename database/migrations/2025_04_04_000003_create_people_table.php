<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique()->comment('کد شش رقمی یکتا');
            $table->string('title')->nullable()->comment('عنوان (آقا، خانم، دکتر و...)');
            $table->string('first_name')->nullable()->comment('نام');
            $table->string('last_name')->nullable()->comment('نام خانوادگی');
            $table->string('display_name')->nullable()->comment('نام نمایشی یا مستعار');
            $table->string('national_code', 10)->nullable()->unique()->comment('کد ملی/شناسه ملی');
            $table->string('economic_code', 12)->nullable()->comment('کد اقتصادی');
            $table->string('registration_number', 20)->nullable()->comment('شماره ثبت');
            $table->enum('type', ['individual', 'company'])->default('individual')->comment('نوع شخص');
            $table->string('company_name')->nullable()->comment('نام شرکت');
            
            // اطلاعات تماس
            $table->string('mobile', 11)->nullable()->comment('موبایل');
            $table->string('phone', 11)->nullable()->comment('تلفن');
            $table->string('email')->nullable()->comment('ایمیل');
            $table->string('website')->nullable()->comment('وب‌سایت');
            $table->text('address')->nullable()->comment('آدرس');
            $table->string('postal_code', 10)->nullable()->comment('کد پستی');
            $table->string('country')->default('ایران')->comment('کشور');
            $table->string('state')->nullable()->comment('استان');
            $table->string('city')->nullable()->comment('شهر');
            
            // دسته‌بندی و وضعیت
            $table->foreignId('category_id')->nullable()->constrained('person_categories')->nullOnDelete()->comment('دسته‌بندی');
            $table->boolean('is_customer')->default(false)->comment('مشتری');
            $table->boolean('is_supplier')->default(false)->comment('تامین کننده');
            $table->boolean('is_employee')->default(false)->comment('کارمند');
            $table->boolean('is_shareholder')->default(false)->comment('سهامدار');
            
            // اطلاعات مالی
            $table->decimal('credit_limit', 20, 2)->default(0)->comment('سقف اعتبار');
            $table->decimal('opening_balance', 20, 2)->default(0)->comment('مانده اول دوره');
            
            $table->string('image')->nullable()->comment('تصویر');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->boolean('is_active')->default(true)->comment('وضعیت فعال/غیرفعال');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('code');
            $table->index('national_code');
            $table->index('type');
            $table->index('mobile');
            $table->index('category_id');
            $table->index('is_customer');
            $table->index('is_supplier');
            $table->index('is_employee');
            $table->index('is_shareholder');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
};