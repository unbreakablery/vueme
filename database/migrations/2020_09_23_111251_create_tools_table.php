<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('');
            $table->string('path', 255)->nullable()->default(null);
            $table->string('slug', 255)->nullable()->default(null);
            $table->string('color', 10)->nullable()->default(null);
			$table->timestamps();
			
        });

        Schema::create('user_tools', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index('user_id_fk');
			$table->integer('tools_id')->unsigned()->index('tools_id_fk');
			$table->timestamps();			
			$table->unique(['user_id','tools_id'], 'user_tools_id_uindex');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tools');
        Schema::dropIfExists('tools');
        
    }
}
