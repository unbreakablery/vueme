<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('');
            $table->string('path', 255)->nullable()->default(null);
            $table->string('slug', 255)->nullable()->default(null);
            $table->string('color', 10)->nullable()->default(null);
			$table->timestamps();
			
        });

        Schema::create('user_specialties', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index('user_id_fk');
			$table->integer('specialties_id')->unsigned()->index('specialties_id_fk');
			$table->timestamps();			
			$table->unique(['user_id','specialties_id'], 'user_specialties_id_uindex');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_specialties');
        Schema::drop('specialties');
        
    }
}
