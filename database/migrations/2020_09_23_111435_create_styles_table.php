<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('styles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('');
            $table->string('path', 255)->nullable()->default(null);
            $table->string('slug', 255)->nullable()->default(null);
            $table->string('color', 10)->nullable()->default(null);
			$table->timestamps();
			
        });

        Schema::create('user_styles', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index('user_id_fk');
			$table->integer('styles_id')->unsigned()->index('styles_id_fk');
			$table->timestamps();			
			$table->unique(['user_id','styles_id'], 'user_styles_id_uindex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_styles');
        Schema::dropIfExists('styles');
    }
}
