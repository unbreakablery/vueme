<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('');
            $table->string('path', 255)->nullable()->default(null);
            $table->string('slug', 255)->nullable()->default(null);
            $table->string('color', 10)->nullable()->default(null);
			$table->timestamps();
			
        });

        Schema::create('user_languages', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index('user_id_fk');
			$table->integer('languages_id')->unsigned()->index('languages_id_fk');
			$table->timestamps();			
			$table->unique(['user_id','languages_id'], 'user_languages_id_uindex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_languages');
        Schema::dropIfExists('languages');
    }
}
