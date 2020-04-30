<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 64);
            $table->string('subtitle', 2048);
            $table->string('file_id')->nullable();
            $table->string('about', 4048);
            $table->string('phone', 20);
            $table->string('email', 128);
            $table->string('viber', 20);
            $table->string('telegram', 20);
            $table->string('whatsapp', 20);
            $table->string('facebook', 128);
            $table->string('instagram', 128);
            $table->string('map', 4048);
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
        Schema::dropIfExists('settings');
    }
}
