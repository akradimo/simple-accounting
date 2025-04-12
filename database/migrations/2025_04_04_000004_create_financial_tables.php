<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // جدول حساب‌ها
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('کد حساب');
            $table->string('name')->comment('نام حساب');
            $table->string('type')->comment('نوع حساب');
            $table->decimal('balance', 20, 2)->default(0)->comment('مانده حساب');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->boolean('is_active')->default(true)->comment('وضعیت');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('code');
            $table->index('type');
            $table->index('is_active');
        });

        // جدول حساب‌های بانکی
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('نام بانک');
            $table->string('branch')->nullable()->comment('شعبه');
            $table->string('account_number')->comment('شماره حساب');
            $table->string('card_number')->nullable()->comment('شماره کارت');
            $table->string('shaba')->nullable()->comment('شماره شبا');
            $table->decimal('balance', 20, 2)->default(0)->comment('موجودی');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->boolean('is_active')->default(true)->comment('وضعیت');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('account_number');
            $table->index('card_number');
            $table->index('shaba');
            $table->index('is_active');
        });

        // جدول صندوق‌ها
        Schema::create('cashboxes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('نام صندوق');
            $table->string('location')->nullable()->comment('محل صندوق');
            $table->foreignId('responsible_person_id')->nullable()->constrained('people')->onDelete('set null')->comment('مسئول صندوق');
            $table->decimal('balance', 20, 2)->default(0)->comment('موجودی');
            $table->decimal('min_balance', 20, 2)->default(0)->comment('حداقل موجودی');
            $table->decimal('max_balance', 20, 2)->default(0)->comment('حداکثر موجودی');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->boolean('is_active')->default(true)->comment('وضعیت');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('responsible_person_id');
            $table->index('is_active');
        });

        // جدول اصلی دریافت
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('number', 8)->unique()->comment('شماره دریافت');
            $table->date('date')->comment('تاریخ دریافت');
            $table->foreignId('project_id')->nullable()->constrained('projects')
                ->onDelete('restrict')->comment('پروژه مربوطه');
            $table->string('description', 200)->nullable()->comment('شرح دریافت');
            $table->string('currency', 3)->default('IRR')->comment('واحد پول');
            $table->foreignId('person_id')->constrained('people')
                ->onDelete('restrict')->comment('شخص');
            $table->decimal('amount', 20, 2)->default(0)->comment('مبلغ');
            $table->boolean('is_active')->default(true)->comment('وضعیت');
            $table->boolean('status')->default(true)->comment('وضعیت پرداخت');
            $table->foreignId('created_by')->nullable()->constrained('users')->comment('ایجاد کننده');
            $table->foreignId('updated_by')->nullable()->constrained('users')->comment('ویرایش کننده');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('number');
            $table->index('date');
            $table->index('project_id');
            $table->index('person_id');
            $table->index('is_active');
            $table->index('status');
            $table->index('created_by');
            $table->index('updated_by');
        });

        // جدول آیتم‌های دریافت
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->constrained()->onDelete('cascade')
                ->comment('دریافت مربوطه');
            $table->foreignId('person_id')->constrained('people')
                ->comment('شخص دریافت کننده');
            $table->decimal('amount', 20, 2)->default(0)->comment('مبلغ');
            $table->text('description')->nullable()->comment('شرح');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('receipt_id');
            $table->index('person_id');
        });

        // جدول پرداخت‌های دریافت
        Schema::create('receipt_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->constrained()->onDelete('cascade')
                ->comment('دریافت مربوطه');
            $table->enum('type', ['cash', 'petty-cash', 'bank', 'check', 'contact', 'account'])
                ->comment('نوع پرداخت');
            $table->decimal('amount', 20, 2)->default(0)->comment('مبلغ');
            $table->string('reference')->nullable()->comment('شماره مرجع');
            $table->json('details')->nullable()->comment('جزئیات');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('receipt_id');
            $table->index('type');
            $table->index('reference');
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipt_payments');
        Schema::dropIfExists('receipt_items');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('cashboxes');
        Schema::dropIfExists('banks');
        Schema::dropIfExists('accounts');
    }
};