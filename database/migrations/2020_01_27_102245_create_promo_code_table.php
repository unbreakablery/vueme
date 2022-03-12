<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_code', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',255)->nullable()->default(null);
            $table->integer('credits')->nullable()->default(0);
            $table->integer('times_used')->nullable()->default(0);
            $table->integer('max_use')->nullable()->default(0);
            $table->tinyInteger('status')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_code');
    }
}
