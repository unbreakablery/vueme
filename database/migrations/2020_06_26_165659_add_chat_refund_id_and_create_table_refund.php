<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChatRefundIdAndCreateTableRefund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund', function (Blueprint $table) {
            $table->increments('id');            
            $table->string("name")->nullable();           
            $table->mediumText("description")->nullable();
            $table->timestamps();
        });
        Schema::table('chat', function (Blueprint $table) {

            $table->integer('refund_id')->default(null)->nullable();
                           
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
