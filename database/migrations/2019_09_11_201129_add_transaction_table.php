<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transaction_type', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('type',255);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('order', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('type',255);
            $table->integer('credits')->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('order', function(Blueprint $table)
        {
            $table->foreign('user_id', 'FK_order_user')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::create('transaction', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->index('order_id')->nullable();
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('billing_id')->unsigned()->index('billing_id')->nullable();
            $table->double('amount')->nullable();
            $table->string('action',255);
            $table->integer('credits_old')->default(0);
            $table->string('result_text',255)->nullable();
            $table->string('result_code',255)->nullable();
            $table->string('result_avs',255)->nullable();
            $table->string('result',255)->nullable();
            $table->string('result_type',255)->nullable();
            $table->string('result_cvv',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('transaction', function(Blueprint $table)
        {

            $table->foreign('billing_id', 'FK_user_biller_edata_transaction')->references('id')->on('user_biller_edata')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user_id', 'FK_user_transaction')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('order_id', 'FK_order_transaction')->references('id')->on('order')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('transaction_type_id', 'FK_transaction_type_transaction')->references('id')->on('transaction_type')->onUpdate('CASCADE')->onDelete('CASCADE');
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
