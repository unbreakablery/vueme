<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToUserStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('styles', function (Blueprint $table) {
            $table->increments('id')->change();
        });
        Schema::table('user_styles', function (Blueprint $table) {
            $table->foreign('user_id', 'user_id_ibfk_4')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('styles_id', 'styles_id_fk')->references('id')->on('styles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_styles', function (Blueprint $table) {
             
            $table->dropForeign('user_id_ibfk_4');
            $table->dropForeign('styles_id_fk');
        });
    }
}
