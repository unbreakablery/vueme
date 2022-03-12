<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_reply', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('psychic_id')->nullable()->default(null)->unsigned()->index('review_reply_psychic_id_fk');
            $table->integer('review_id')->nullable()->default(null)->unsigned()->index('review_reply_review_id_fk');
            $table->string('status', 255)->nullable()->default('Pending');
            $table->text('text')->nullable();
            $table->timestamps();
            $table->timestamp('posted_at')->nullable()->default(null);
            $table->foreign('psychic_id', 'review_reply_psychic_id_ibfk_1')->references('id')->on('user')->onDelete('CASCADE');
            $table->foreign('review_id', 'review_reply_id_ibfk_1')->references('id')->on('review')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_reply');
    }
}
