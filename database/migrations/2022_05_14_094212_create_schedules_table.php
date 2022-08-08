<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->time('departure_time');
            $table->foreignId('arrival_province_id')->constrained('stations','id');
            $table->foreignId('service_provider_id')->constrained();
            $table->smallInteger('duration')->unsigned()->comment('by minutes');
            $table->foreignId('destination_province_id')->constrained('stations','id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
