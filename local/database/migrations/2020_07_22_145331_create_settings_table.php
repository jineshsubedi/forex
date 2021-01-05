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
            $table->increments('id');
            $table->string('app_name');
            $table->string('sub_name')->nullable();
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('page_banner')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('map', 1000)->nullable();
            $table->string('location')->nullable();
            $table->string('phone_number1')->nullable();
            $table->string('phone_number2')->nullable();
            $table->string('business_time', 500)->nullable();
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
