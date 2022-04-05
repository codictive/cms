<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->comment('والد');
            $table->string('name')->comment('نام دسته');
            $table->string('slug', UNIQUE_COL_SIZE)->unique()->comment('اسلاگ');
            $table->text('description')->nullable()->comment('توضیحات');
            $table->integer('weight')->default(0)->comment('وزن');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('article_categories')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_categories');
    }
}
