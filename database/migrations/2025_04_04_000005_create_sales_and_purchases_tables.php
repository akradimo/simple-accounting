<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // جدول مدیریت انبار و محصولات
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('کد کالا');
            $table->string('name')->comment('نام کالا');
            $table->string('unit')->comment('واحد شمارش');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->decimal('purchase_price', 20, 2)->default(0)->comment('قیمت خرید');
            $table->decimal('sale_price', 20, 2)->default(0)->comment('قیمت فروش');
            $table->integer('current_quantity')->default(0)->comment('موجودی فعلی');
            $table->integer('minimum_quantity')->default(0)->comment('حداقل موجودی');
            $table->integer('maximum_quantity')->default(0)->comment('حداکثر موجودی');
            $table->string('barcode')->nullable()->unique()->comment('بارکد');
            $table->boolean('is_active')->default(true)->comment('وضعیت فعال/غیرفعال');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('code');
            $table->index('name');
            $table->index('barcode');
            $table->index('is_active');
        });

        // جدول خدمات
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('کد خدمت');
            $table->string('name')->comment('نام خدمت');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->decimal('price', 20, 2)->default(0)->comment('قیمت');
            $table->boolean('is_active')->default(true)->comment('وضعیت فعال/غیرفعال');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('code');
            $table->index('name');
            $table->index('is_active');
        });

        // جدول فروش
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->comment('شماره فاکتور');
            $table->foreignId('customer_id')->constrained('people')->comment('مشتری');
            $table->date('invoice_date')->comment('تاریخ فاکتور');
            $table->date('due_date')->nullable()->comment('تاریخ سررسید');
            $table->string('status')->default('draft')->comment('وضعیت');
            $table->decimal('subtotal', 20, 2)->default(0)->comment('جمع کل');
            $table->decimal('discount_percentage', 5, 2)->default(0)->comment('درصد تخفیف');
            $table->decimal('discount_amount', 20, 2)->default(0)->comment('مبلغ تخفیف');
            $table->decimal('tax_percentage', 5, 2)->default(0)->comment('درصد مالیات');
            $table->decimal('tax_amount', 20, 2)->default(0)->comment('مبلغ مالیات');
            $table->decimal('shipping_cost', 20, 2)->default(0)->comment('هزینه حمل');
            $table->decimal('total_amount', 20, 2)->default(0)->comment('مبلغ نهایی');
            $table->decimal('paid_amount', 20, 2)->default(0)->comment('مبلغ پرداخت شده');
            $table->decimal('remaining_amount', 20, 2)->default(0)->comment('مبلغ باقیمانده');
            $table->text('notes')->nullable()->comment('یادداشت‌ها');
            $table->foreignId('created_by')->nullable()->constrained('users')->comment('ایجاد کننده');
            $table->foreignId('updated_by')->nullable()->constrained('users')->comment('ویرایش کننده');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('invoice_number');
            $table->index('customer_id');
            $table->index('invoice_date');
            $table->index('due_date');
            $table->index('status');
            $table->index('created_by');
            $table->index('updated_by');
        });

        // جدول اقلام فروش
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade')->comment('شماره فاکتور');
            $table->morphs('itemable');  // این خط ایندکس را به صورت خودکار ایجاد می‌کند
            $table->decimal('quantity', 10, 2)->default(0)->comment('تعداد');
            $table->decimal('price', 20, 2)->default(0)->comment('قیمت واحد');
            $table->decimal('discount_percentage', 5, 2)->default(0)->comment('درصد تخفیف');
            $table->decimal('discount_amount', 20, 2)->default(0)->comment('مبلغ تخفیف');
            $table->decimal('tax_percentage', 5, 2)->default(0)->comment('درصد مالیات');
            $table->decimal('tax_amount', 20, 2)->default(0)->comment('مبلغ مالیات');
            $table->decimal('total_amount', 20, 2)->default(0)->comment('مبلغ کل');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('sale_id');
        });

        // جدول خرید
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->comment('شماره فاکتور');
            $table->foreignId('vendor_id')->constrained('people')->comment('تامین کننده');
            $table->date('invoice_date')->comment('تاریخ فاکتور');
            $table->date('due_date')->nullable()->comment('تاریخ سررسید');
            $table->string('status')->default('draft')->comment('وضعیت');
            $table->decimal('subtotal', 20, 2)->default(0)->comment('جمع کل');
            $table->decimal('discount_percentage', 5, 2)->default(0)->comment('درصد تخفیف');
            $table->decimal('discount_amount', 20, 2)->default(0)->comment('مبلغ تخفیف');
            $table->decimal('tax_percentage', 5, 2)->default(0)->comment('درصد مالیات');
            $table->decimal('tax_amount', 20, 2)->default(0)->comment('مبلغ مالیات');
            $table->decimal('shipping_cost', 20, 2)->default(0)->comment('هزینه حمل');
            $table->decimal('total_amount', 20, 2)->default(0)->comment('مبلغ نهایی');
            $table->decimal('paid_amount', 20, 2)->default(0)->comment('مبلغ پرداخت شده');
            $table->decimal('remaining_amount', 20, 2)->default(0)->comment('مبلغ باقیمانده');
            $table->text('notes')->nullable()->comment('یادداشت‌ها');
            $table->foreignId('created_by')->nullable()->constrained('users')->comment('ایجاد کننده');
            $table->foreignId('updated_by')->nullable()->constrained('users')->comment('ویرایش کننده');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('invoice_number');
            $table->index('vendor_id');
            $table->index('invoice_date');
            $table->index('due_date');
            $table->index('status');
            $table->index('created_by');
            $table->index('updated_by');
        });

        // جدول اقلام خرید
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade')->comment('شماره فاکتور');
            $table->morphs('itemable');  // این خط ایندکس را به صورت خودکار ایجاد می‌کند
            $table->decimal('quantity', 10, 2)->default(0)->comment('تعداد');
            $table->decimal('price', 20, 2)->default(0)->comment('قیمت واحد');
            $table->decimal('discount_percentage', 5, 2)->default(0)->comment('درصد تخفیف');
            $table->decimal('discount_amount', 20, 2)->default(0)->comment('مبلغ تخفیف');
            $table->decimal('tax_percentage', 5, 2)->default(0)->comment('درصد مالیات');
            $table->decimal('tax_amount', 20, 2)->default(0)->comment('مبلغ مالیات');
            $table->decimal('total_amount', 20, 2)->default(0)->comment('مبلغ کل');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('purchase_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('services');
        Schema::dropIfExists('products');
    }
};