<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromoCodeToUserCreditLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_credit_log', function (Blueprint $table) {
            $table->string('promo_code',255)->nullable()->default(null);
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
            $table->dropColumn('promo_code');
        });
    }
}
