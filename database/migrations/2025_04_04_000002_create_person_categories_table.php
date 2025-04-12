<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('person_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('نام دسته‌بندی');
            $table->string('code')->unique()->nullable()->comment('کد دسته‌بندی');
            $table->string('color', 7)->comment('رنگ (#RRGGBB)');
            $table->string('icon')->nullable()->comment('نام آیکون');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->integer('order')->default(0)->comment('ترتیب نمایش');
            $table->boolean('is_active')->default(true)->comment('وضعیت');
            $table->timestamps();
            $table->softDeletes();
            
            // ایندکس‌ها
            $table->index('code');
            $table->index('is_active');
            $table->index('order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('person_categories');
    }
};