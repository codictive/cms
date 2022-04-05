<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->nullable()->comment('شناسه کاربر');
            $table->unsignedBigInteger('province_id')->nullable()->comment('شناسه استان');
            $table->unsignedBigInteger('city_id')->nullable()->comment('شناسه شهر');
            $table->string('name')->nullable()->comment('نام و نام خانوادگی');
            $table->string('gender')->nullable()->comment('جنسیت');
            $table->string('national_code')->nullable()->comment('کد ملی');
            $table->string('image')->nullable()->comment('تصویر پروفایل');
            $table->string('lat')->nullable()->comment('موقعیت جغرافیایی؛ طول');
            $table->string('lng')->nullable()->comment('موقعیت جغرافیایی؛ عرض');
            $table->boolean('is_approved')->default(false)->comment('تائید شده/نشده');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('province_id')->references('id')->on('provinces')->nullOnDelete();
            $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
