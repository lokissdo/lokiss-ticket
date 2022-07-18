<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddForeignkeyInServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (Schema::hasColumn('service_providers', 'employer_id')) {
        //     Schema::table('service_providers', function (Blueprint $table) {
        //         $table->dropColumn('employer_id');
        //     });
        //     Schema::table('service_providers', function (Blueprint $table) {
        //         $table->foreignId('employer_id')->constrained('users','id');
        //     });
        // }
        // else Schema::table('service_providers', function (Blueprint $table) {
        //     $table->foreignId('employer_id')->constrained('users','id')->change();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_providers', function (Blueprint $table) {
            //
        });
    }
}
