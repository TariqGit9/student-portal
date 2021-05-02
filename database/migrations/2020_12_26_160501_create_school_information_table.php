<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_information', function (Blueprint $table) {
            $table->id();
            $table->string('school_unique_id');
            $table->string('avatar')->nullable();
            $table->string('name');
            $table->string('abbreviation');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('phone2');
            $table->string('address');
            $table->integer('status')->default(1);
            $table->longtext('details');
            $table->string('ip_address')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('school_information');
    }
}
