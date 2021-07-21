<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassStudentFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_student_fees', function (Blueprint $table) {

            $table->id();

            $table->string('date_paid')->nullable();

            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('fee_id')->nullable();
            $table->foreign('fee_id')->references('id')->on('class_fees')->onDelete('cascade');

            
            $table->double('amount_paid', 15, 8);
            $table->double('amount_left', 15, 8);
            $table->string('amount_description');
            
            $table->double('fees_left', 15, 8);
            $table->string('fees_left_description');

            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('school_session_id')->nullable();

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
        Schema::dropIfExists('class_student_fees');
    }
}
