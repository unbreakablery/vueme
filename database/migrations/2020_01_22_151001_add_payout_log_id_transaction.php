<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayoutLogIdTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('payout_log', function(Blueprint $table)
		{
            $table->integer('transaction_id')->after('psychic_id')->nullable()->unsigned()->index('transaction_id');
			$table->foreign('transaction_id', 'transaction_payout_log_ibfk_2')->references('id')->on('transaction');
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
