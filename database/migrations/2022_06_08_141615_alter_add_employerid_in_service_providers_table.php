<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddEmployeridInServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('service_providers', 'employer_id')) {
            Schema::table('service_providers', function (Blueprint $table) {
                   $table->foreignId('employer_id')->constrained('users','id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('service_providers', 'employer_id')) {
            Schema::table('service_providers', function (Blueprint $table) {
                $table->dropForeign(['employer_id']);
                $table->dropColumn('employer_id');
            });
        }
    }
}
