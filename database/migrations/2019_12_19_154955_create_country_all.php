<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_all', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('flag')->nullable();
            $table->string('code2')->nullable();
            $table->string('code3')->nullable();
            $table->string('country')->nullable();
            $table->string('capital')->nullable();
            $table->integer('prefix')->nullable();
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
        Schema::dropIfExists('country_all');
    }
}
