<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->nullable()->comment('شناسه نویسنده');
            $table->unsignedBigInteger('article_category_id')->nullable()->comment('شناسه دسته');
            $table->string('title')->comment('عنوان');
            $table->string('slug', UNIQUE_COL_SIZE)->unique()->comment('اسلاگ');
            $table->string('headline')->nullable()->comment('سر تیتر');
            $table->string('image')->nullable()->comment('تصویر اصلی');
            $table->text('summary')->nullable()->comment('متن خلاصه');
            $table->longText('body')->comment('متن کامل');
            $table->boolean('published')->default(true)->comment('منتشر شده');
            $table->boolean('promote_to_homepage')->default(false)->comment('نمایش در صفحه اصلی');
            $table->boolean('stick_to_top')->default(false)->comment('نمایش در ابتدای فهرست');
            $table->text('meta_keywords')->nullable()->comment('کلیدواژه‌های متا');
            $table->text('meta_description')->nullable()->comment('توضیحات متا');
            $table->integer('hits')->default(0)->comment('تعداد بازدید');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('article_category_id')->references('id')->on('article_categories')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
