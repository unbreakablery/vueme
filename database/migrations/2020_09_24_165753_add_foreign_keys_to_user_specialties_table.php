<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToUserSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('specialties', function (Blueprint $table) {
            $table->increments('id')->change();
        });

        Schema::table('user_specialties', function (Blueprint $table) {
            $table->foreign('user_id', 'user_id_ibfk_2')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('specialties_id', 'specialties_id_fk')->references('id')->on('specialties')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_specialties', function (Blueprint $table) {
            
            $table->dropForeign('user_id_ibfk_2');
            $table->dropForeign('specialties_id_fk');
        });
    }
}
