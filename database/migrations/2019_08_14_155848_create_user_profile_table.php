<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->string('display_name', 64)->default('');
            $table->string('country_code', 2)->nullable()->default('US');
            $table->date('birth_date')->nullable();
            $table->string('gender', 50)->nullable()->default('UNSPECIFIED');
            $table->string('profile_link', 255)->nullable()->default('');
            $table->string('social_link_one', 255)->nullable()->default(null);
            $table->string('social_link_two', 255)->nullable()->default(null);
            $table->string('social_link_three', 255)->nullable()->default(null);
            $table->text('description')->nullable();
            $table->string('haedshot_path', 255)->nullable()->default('');
            $table->string('full_body_path', 255)->nullable()->default('');

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
        Schema::table('user_profile', function (Blueprint $table) {
            //
        });
    }
}
