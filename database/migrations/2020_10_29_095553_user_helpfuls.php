<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserHelpfuls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_helpfuls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_helpfuls_id_fk');
            $table->integer('review_id')->unsigned()->index('review_helpfuls_id_fk');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('review_id')->references('id')->on('review')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unique(['user_id','review_id'], 'user_helpfuls_id_uindex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_helpfuls');
    }
}
