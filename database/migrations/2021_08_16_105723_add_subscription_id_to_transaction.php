<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionIdToTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->integer('subscription_id')->nullable()->default(null)->unsigned()->index('subscription_id_transaction_ibfk_1')->after('user_id');
            $table->foreign('subscription_id', 'transaction_subscription_id_ibfk_1')->references('id')->on('subscription')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('transaction_type_id')->unsigned()->index('transaction_type_id');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction', function (Blueprint $table) {
            //
        });
    }
}
