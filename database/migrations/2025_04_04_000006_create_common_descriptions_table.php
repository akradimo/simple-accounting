<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('common_descriptions', function (Blueprint $table) {
            $table->id();
            $table->text('description')->comment('شرح متداول');
            $table->string('type')->nullable()->comment('نوع شرح');
            $table->string('group')->nullable()->comment('گروه شرح');
            $table->boolean('is_active')->default(true)->comment('وضعیت');
            $table->integer('usage_count')->default(0)->comment('تعداد دفعات استفاده');
            $table->foreignId('created_by')->nullable()->constrained('users')->comment('ایجاد کننده');
            $table->foreignId('updated_by')->nullable()->constrained('users')->comment('ویرایش کننده');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('type');
            $table->index('group');
            $table->index('is_active');
            $table->index('usage_count');
            $table->index('created_by');
            $table->index('updated_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('common_descriptions');
    }
};