<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_attendances', function (Blueprint $table) {
            $table->id();

            $table->string('type')->nullable();

            $table->string('date')->nullable(0);

            $table->string('time')->nullable(0);
            
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->foreign('grade_id')->references('id')->on('class_grades')->onDelete('cascade');
            
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('class_id')->nullable();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->unsignedBigInteger('school_id')->nullable();
            
            $table->unsignedBigInteger('school_session_id')->nullable();

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
        Schema::dropIfExists('class_attendances');
    }
}
