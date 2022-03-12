<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePayoutLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('psychic_id')->unsigned();
            $table->integer('earnings');
            $table->integer('payout');
            $table->date('start_period');
            $table->date('end_period');
            $table->date('pay_day');

            $table->string('status')->default('Pending');
            $table->timestamps();
        });

        Schema::table('payout_log', function(Blueprint $table)
        {
            $table->foreign('psychic_id', 'user_payout_log_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payout_log');
    }
}
