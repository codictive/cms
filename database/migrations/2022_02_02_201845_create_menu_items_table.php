<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id')->comment('شماره منو');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('والد');
            $table->string('title')->comment('عنوان منو');
            $table->string('path')->comment('آدرس');
            $table->integer('weight')->default(0)->comment('وزن');
            $table->string('prefix')->nullable()->comment('پیشوند');
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus')->cascadeOnDelete();
            $table->foreign('parent_id')->references('id')->on('menu_items')->cascadeOnDelete();
        });

        tableComment('menu_items', 'آیتم‌های منو');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
