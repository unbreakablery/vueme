<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFavoritePsychics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_favorite_psychics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_id_fk');
            $table->integer('psychic_id')->unsigned()->index('psychic_id_fk');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('psychic_id')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unique(['user_id','psychic_id'], 'user_psychic_id_uindex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_favorite_psychics');
    }
}
