<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToUserLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->increments('id')->change();
        });
        Schema::table('user_languages', function (Blueprint $table) {
            $table->foreign('user_id', 'user_id_ibfk_5')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('languages_id', 'languages_id_fk')->references('id')->on('languages')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_languages', function (Blueprint $table) {
             
            $table->dropForeign('user_id_ibfk_5');
            $table->dropForeign('languages_id_fk');
        });
    }
}
