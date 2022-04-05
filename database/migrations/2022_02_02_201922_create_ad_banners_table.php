<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_banners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('نام');
            $table->string('link')->nullable()->comment('لینک');
            $table->string('file_name')->comment('نام فایل');
            $table->string('kind')->index()->nullable()->comment('image|video|audio|...');
            $table->string('mimetype')->index()->nullable()->comment('mime/type');
            $table->integer('size')->nullable()->comment('سایز');
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
        Schema::dropIfExists('ad_banners');
    }
}
