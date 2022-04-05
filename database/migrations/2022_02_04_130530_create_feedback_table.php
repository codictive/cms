<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('author_name')->comment('نام نویسنده');
            $table->string('author_mobile')->comment('موبایل نویسنده');
            $table->string('subject')->comment('موضوع');
            $table->string('department')->comment('دپارتمان');
            $table->longText('body')->comment('متن پیام');
            $table->boolean('seen')->default(0)->comment('خوانده شده/نشده');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
