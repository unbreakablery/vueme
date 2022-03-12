<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablePayotLogEarningsAndPayoutToFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payout_log', function (Blueprint $table) {
            $table->float('earnings', 9, 2)->default(0)->change();
            $table->float('payout', 9, 2)->default(0)->change();
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('float', function (Blueprint $table) {
            //
        });
    }
}
