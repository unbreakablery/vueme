<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoBuyCreditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_buy_credit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',255)->nullable()->default(null);
            $table->text('credits')->nullable()->default(null);
            $table->tinyInteger('active')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('user_credit_log', function (Blueprint $table) {
            $table->bigInteger('promo_id')->unsigned()->nullable()->default(null);
            $table->foreign('promo_id')->references('id')->on('promo_buy_credit');
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
            $table->dropColumn('promo_id');
        });

        Schema::dropIfExists('promo_buy_credit');
    }
}
