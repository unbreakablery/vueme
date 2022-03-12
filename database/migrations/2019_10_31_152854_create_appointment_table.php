<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(null)->unsigned()->index('appointment_user_id_fk');
            $table->integer('psychic_id')->nullable()->default(null)->unsigned()->index('appointment_psychic_id_fk');
            $table->integer('service_id')->nullable()->default(null)->unsigned()->index('appointment_service_id_fk');
            $table->string('status', 255)->nullable()->default('Pending');
            $table->timestamp('start_hour')->nullable()->default(null);
            $table->timestamp('end_hour')->nullable()->default(null);
            $table->text('text')->nullable();
            $table->date('date')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('user_id', 'appointment_user_id_ibfk_1')->references('id')->on('user')->onDelete('CASCADE');
            $table->foreign('psychic_id', 'appointment_psychic_id_ibfk_1')->references('id')->on('user')->onDelete('CASCADE');
            $table->foreign('service_id', 'appointment_service_id_ibfk_1')->references('id')->on('services')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment');
    }
}
