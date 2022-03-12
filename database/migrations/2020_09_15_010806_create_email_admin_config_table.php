<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailAdminConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_admin_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emails')->nullable();
            $table->string('subject')->nullable();
            $table->timestamp('date')->nullable()->default(null);
            $table->string('timezone', 50)->nullable()->default(null);
            $table->string('type', 10)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_admin_config');
    }
}
