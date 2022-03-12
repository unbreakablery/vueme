<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(null)->unsigned()->index('review_user_id_fk');
            $table->integer('psychic_id')->nullable()->default(null)->unsigned()->index('review_psychic_id_fk');
            $table->integer('service_id')->nullable()->default(null)->unsigned()->index('review_service_id_fk');
            $table->string('title', 255)->nullable()->default(null);
            $table->string('status', 255)->nullable()->default('Pending');
            $table->text('text')->nullable();
            $table->integer('rating')->nullable()->default(0);
            $table->timestamps();
            $table->timestamp('posted_at')->nullable()->default(null);
            $table->foreign('user_id', 'review_user_id_ibfk_1')->references('id')->on('user')->onDelete('CASCADE');
            $table->foreign('psychic_id', 'review_psychic_id_ibfk_1')->references('id')->on('user')->onDelete('CASCADE');
            $table->foreign('service_id', 'review_service_id_ibfk_1')->references('id')->on('services')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review');
    }
}
