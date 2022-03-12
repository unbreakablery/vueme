<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCreditsToFloatOnUserCreditLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_credit_log', function (Blueprint $table) {

            $table->float('credits', 9, 2)->default(0)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_credit_log', function (Blueprint $table) {

            $table->integer('credits')->default(0)->change();

        });
    }
}
