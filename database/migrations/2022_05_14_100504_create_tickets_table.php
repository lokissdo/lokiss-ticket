<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('trip_id')->constrained();
            $table->tinyInteger('seat_position');
            $table->foreignId('arrival_station_id')->constrained('stations','id');
            $table->foreignId('departure_station_id')->constrained('stations','id');
            $table->primary(['trip_id','seat_position']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
