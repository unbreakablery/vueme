<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceIdTo11ChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_1_1_chat_request', function (Blueprint $table) {
            $table->integer('service_id')->unsigned();
            $table->integer('max_minutes')->unsigned();
            $table->integer('minimum_minutes')->unsigned();
            //$table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_1_1_chat_request', function (Blueprint $table) {
            //
            $table->dropColumn('service_id');
            $table->dropColumn('max_minutes');
            $table->dropColumn('minimum_minutes');
        });
    }
}
