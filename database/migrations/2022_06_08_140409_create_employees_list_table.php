<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_list', function (Blueprint $table) {
           $table->foreignId('id')->constrained('users','id');
           $table->foreignId('service_provider_id')->constrained();
           $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
           $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_list');
    }
}
