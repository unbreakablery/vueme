<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryToReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->default(null)->unsigned()->index('review_category_id_fk');
            $table->foreign('category_id', 'review_category_idFK1')->references('id')->on('category')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review', function (Blueprint $table) {
            //
        });
    }
}
