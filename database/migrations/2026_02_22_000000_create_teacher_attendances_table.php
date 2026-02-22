<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('teacher_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('time')->nullable();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('school_session_id')->nullable();
            $table->unsignedBigInteger('marked_by')->nullable();
            $table->foreign('marked_by')->references('id')->on('users')->onDelete('set null');
            $table->string('ip_address')->nullable();
            $table->unique(['date', 'school_id', 'school_session_id']);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('teacher_attendance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_attendance_id');
            $table->foreign('teacher_attendance_id')->references('id')->on('teacher_attendances')->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('attendance')->nullable();
            $table->boolean('on_time')->default(true);
            $table->string('ip_address')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_attendance_details');
        Schema::dropIfExists('teacher_attendances');
    }
}
