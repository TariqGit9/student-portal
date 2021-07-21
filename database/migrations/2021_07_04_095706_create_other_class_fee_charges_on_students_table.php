<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherClassFeeChargesOnStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_class_fee_charges_on_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_id')->nullable();
            $table->foreign('fee_id')->references('id')->on('class_fees')->onDelete('cascade');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('amount', 15, 8);
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_class_fee_charges_on_students');
    }
}
