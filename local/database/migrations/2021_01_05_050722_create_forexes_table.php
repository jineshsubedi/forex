<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forexes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('exchange_date');
            $table->string('iso3');
            $table->string('name');
            $table->integer('unit');
            $table->decimal('buy', 15, 2 );
            $table->decimal('sell', 15, 2 );
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
        Schema::dropIfExists('forexes');
    }
}
