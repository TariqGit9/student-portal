<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMailsOfTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_mails_of_teachers', function (Blueprint $table) {
           
                $table->id();
    
                $table->unsignedBigInteger('student_id');
                $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
                
                $table->unsignedBigInteger('teacher_id')->nullable();
                $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
                
                
                $table->unsignedBigInteger('school_id')->nullable();
    
                $table->unsignedBigInteger('class_id')->nullable();
                $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
               
                $table->unsignedBigInteger('subject_id')->nullable();
                $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
    
                $table->string('title')->nullable();
    
                $table->longtext('description')->nullable();
    
                $table->integer('status')->default(0);
                $table->string('ip_address')->nullable();
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
        Schema::dropIfExists('student_mails_of_teachers');
    }
}
