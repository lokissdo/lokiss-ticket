<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Arrivals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrivals', function (Blueprint $table) {
            $table->foreignId('trip_id')->constrained();
            $table->foreignId('station_id')->constrained();
            $table->timestamp('time');
            $table->tinyInteger('order');
            $table->primary(['trip_id', 'station_id']);
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrivals');
    }
}
