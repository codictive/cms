<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->comment('شناسه کاربر فرستنده');
            $table->unsignedBigInteger('receiver_id')->nullable()->comment('شناسه کاربر گیرنده');
            $table->unsignedBigInteger('ticket_id')->comment('شناسه تیکت');
            $table->string('type')->default('text')->comment('نوع محتوا؛ متن، فایل');
            $table->text('body')->nullable()->comment('متن پیام');
            $table->boolean('seen')->default(false)->comment('خوانده شده/نشده');
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
    }
}
