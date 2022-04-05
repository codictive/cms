<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('عنوان');
            $table->string('slug', UNIQUE_COL_SIZE)->unique()->comment('اسلاگ');
            $table->string('headline')->nullable()->comment('سر تیتر');
            $table->string('image')->nullable()->comment('تصویر اصلی');
            $table->text('summary')->nullable()->comment('متن خلاصه');
            $table->longText('body')->comment('متن کامل');
            $table->boolean('published')->default(true)->comment('منتشر شده');
            $table->text('meta_keywords')->nullable()->comment('کلیدواژه‌های متا');
            $table->text('meta_description')->nullable()->comment('توضیحات متا');
            $table->integer('hits')->default(0)->comment('تعداد بازدید');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
