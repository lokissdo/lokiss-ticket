<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->foreignId('ticket_id')->constrained();
            $table->foreignId('transaction_id')->constrained();
            $table->timestamp('arrival_time');
            $table->foreignId('arrival_name')->constrained('stations','id');
            $table->timestamp('destination_time');
            $table->foreignId('destination_name')->constrained('stations','id');
            $table->tinyInteger('order');
            $table->primary(['ticket_id', 'transaction_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
        
    }
}
