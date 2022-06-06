<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained();
            $table->foreignId('station_id')->constrained();
            $table->foreignId('next_station_id')->nullable()->constrained('stations','id');
    });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_details');
    }
}
