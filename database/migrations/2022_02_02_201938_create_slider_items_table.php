<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slider_id')->comment('شناسه اسلایدر');
            $table->string('image')->comment('تصویر اسلاید');
            $table->string('caption')->nullable()->comment('کپشن');
            $table->string('link')->nullable()->comment('لینک');
            $table->integer('weight')->default(0)->comment('وزن');
            $table->timestamps();

            $table->foreign('slider_id')->references('id')->on('sliders')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slider_items');
    }
}
