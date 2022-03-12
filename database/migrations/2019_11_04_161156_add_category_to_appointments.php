<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryToAppointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->default(null)->unsigned()->index('appointment_category_id_fk');
            $table->foreign('category_id', 'appointment_category_idFK1')->references('id')->on('category')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            //
        });
    }
}
