<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('نام پروژه');
            $table->string('code')->nullable()->unique()->comment('کد پروژه');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->date('start_date')->nullable()->comment('تاریخ شروع');
            $table->date('end_date')->nullable()->comment('تاریخ پایان');
            $table->string('status')->default('active')->comment('وضعیت');
            $table->text('notes')->nullable()->comment('یادداشت‌ها');
            $table->foreignId('created_by')->nullable()->constrained('users')->comment('ایجاد کننده');
            $table->foreignId('updated_by')->nullable()->constrained('users')->comment('ویرایش کننده');
            $table->timestamps();
            $table->softDeletes();

            // ایندکس‌ها
            $table->index('status');
            $table->index('created_by');
            $table->index('updated_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};