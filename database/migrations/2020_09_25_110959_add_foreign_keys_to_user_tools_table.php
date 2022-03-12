<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToUserToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('tools', function (Blueprint $table) {
            $table->increments('id')->change();
        });
        Schema::table('user_tools', function (Blueprint $table) {
            $table->foreign('user_id', 'user_id_ibfk_3')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('tools_id', 'tools_id_fk')->references('id')->on('tools')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_tools', function (Blueprint $table) {
             
            $table->dropForeign('user_id_ibfk_3');
            $table->dropForeign('tools_id_fk');
        });
    }
}
