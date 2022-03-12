<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserCreditLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_credit_log', function (Blueprint $table) {
            $table->integer('transaction_id')->unsigned()->nullable()->default(null);
            $table->foreign('transaction_id')->references('id')->on('transaction');
        });
        Schema::table('transaction', function (Blueprint $table) {
            $table->longText('apple_identifier')->nullable()->default(null);          
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
