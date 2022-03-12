<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_document', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 100);
            $table->string('vault', 100);
            $table->unsignedInteger("user_id")->index()->nullable();
            $table->timestamps();
            $table->string('documentNumber', 100)->nullable();
            $table->string('firstName', 100)->nullable();
            $table->string('lastName', 100)->nullable();
            $table->string('fullName', 200)->nullable();
            $table->string('sex', 10)->nullable();
            $table->string('height', 10)->nullable();
            $table->string('weight', 10)->nullable();
            $table->smallInteger('age')->nullable();
            $table->timestamp('dob')->nullable();
            $table->smallInteger('dob_day')->nullable();
            $table->smallInteger('dob_month')->nullable();
            $table->smallInteger('dob_year')->nullable();
            $table->timestamp('expiry')->nullable();
            $table->smallInteger('expiry_day')->nullable();
            $table->smallInteger('expiry_month')->nullable();
            $table->smallInteger('expiry_year')->nullable();
            $table->integer('daysToExpiry')->nullable();
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->smallInteger('postcode')->nullable();
            $table->string('vehicleClass', 10)->nullable();
            $table->string('endorsement', 100)->nullable();
            $table->string('documentSide', 10)->nullable();
            $table->string('issuerOrg_region_full', 100)->nullable();
            $table->string('issuerOrg_region_abbr', 100)->nullable();
            $table->string('issuerOrg_full', 100)->nullable();
            $table->boolean('validate_face_picture')->nullable();
            $table->float('authentication_score')->nullable();
            $table->string('documentType', 100)->nullable();
            $table->string('issuerOrg_iso2', 10)->nullable();
            $table->string('issuerOrg_iso3', 10)->nullable();
            $table->string('nationality_full', 100)->nullable();
            $table->string('nationality_iso2', 10)->nullable();
            $table->string('nationality_iso3', 100)->nullable();
            $table->string('internalId', 100)->nullable();
            $table->string('hairColor', 5)->nullable();
            $table->string('eyeColor', 5)->nullable();
            $table->string('middleName', 100)->nullable();
            $table->string('personalNumber', 100)->nullable();
            $table->string('firstName_local', 100)->nullable();
            $table->string('middleName_local', 100)->nullable();
            $table->string('lastName_local', 100)->nullable();
            $table->string('fullName_local', 100)->nullable();
            $table->string('issued', 100)->nullable();
            $table->string('issued_day', 100)->nullable();
            $table->string('issued_month', 100)->nullable();
            $table->string('issued_year', 100)->nullable();
            $table->string('daysFromIssue', 100)->nullable();
            $table->string('placeOfBirth', 255)->nullable();
            $table->string('restrictions', 100)->nullable();
            $table->string('optionalData', 100)->nullable();
            $table->string('optionalData2', 100)->nullable();        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_document');
    }
}
