<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesAndForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add indexes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
            $table->index('user_name');
            $table->index('role_id');
            $table->index('school_information_id');
            $table->index('status');
            $table->index(['role_id', 'school_information_id']);
            $table->index(['status', 'school_information_id']);
        });

        // Add foreign keys to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
            $table->foreign('school_information_id')->references('id')->on('school_information')->onDelete('cascade');
        });

        // Add indexes to student_details table
        Schema::table('student_details', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('class_id');
            $table->index('registration_id');
            $table->index('father_cnic');
            $table->index('phone');
            $table->index(['class_id', 'deleted_at']);
        });

        // Add foreign keys to student_details table
        Schema::table('student_details', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('restrict');
        });

        // Add indexes to teacher_details table
        Schema::table('teacher_details', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('cnic');
            $table->index('phone');
            $table->index('qualification');
        });

        // Add foreign keys to teacher_details table
        Schema::table('teacher_details', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Add indexes to classes table
        Schema::table('classes', function (Blueprint $table) {
            $table->index('class_grade_id');
            $table->index('school_id');
            $table->index('status');
            $table->index(['school_id', 'status']);
        });

        // Add foreign keys to classes table
        Schema::table('classes', function (Blueprint $table) {
            $table->foreign('class_grade_id')->references('id')->on('class_grades')->onDelete('restrict');
            $table->foreign('school_id')->references('id')->on('school_information')->onDelete('cascade');
        });

        // Add indexes to class_subjects table
        Schema::table('class_subjects', function (Blueprint $table) {
            $table->index('class_id');
            $table->index('subject_id');
            $table->index(['class_id', 'subject_id']);
        });

        // Add foreign keys to class_subjects table
        Schema::table('class_subjects', function (Blueprint $table) {
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });

        // Add indexes to teacher_subjects table
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->index('teacher_id');
            $table->index('subject_id');
            $table->index('class_id');
            $table->index(['teacher_id', 'class_id']);
        });

        // Add foreign keys to teacher_subjects table
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });

        // Add indexes to student_marks table
        Schema::table('student_marks', function (Blueprint $table) {
            $table->index('student_id');
            $table->index('assesment_id');
            $table->index(['student_id', 'assesment_id']);
        });

        // Add foreign keys to student_marks table
        Schema::table('student_marks', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assesment_id')->references('id')->on('student_assessments')->onDelete('cascade');
        });

        // Add indexes to student_assessments table
        Schema::table('student_assessments', function (Blueprint $table) {
            $table->index('teacher_id');
            $table->index('class_id');
            $table->index('subject_id');
            $table->index('type_id');
            $table->index('school_session_id');
            $table->index('status');
            $table->index(['class_id', 'subject_id', 'type_id']);
        });

        // Add foreign keys to student_assessments table
        Schema::table('student_assessments', function (Blueprint $table) {
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('result_types')->onDelete('restrict');
            $table->foreign('school_session_id')->references('id')->on('school_sessions')->onDelete('cascade');
        });

        // Add indexes to class_attendances table
        Schema::table('class_attendances', function (Blueprint $table) {
            $table->index('teacher_id');
            $table->index('class_id');
            $table->index('subject_id');
            $table->index('school_session_id');
            $table->index('date');
            $table->index(['class_id', 'subject_id', 'date']);
        });

        // Add foreign keys to class_attendances table
        Schema::table('class_attendances', function (Blueprint $table) {
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('school_session_id')->references('id')->on('school_sessions')->onDelete('cascade');
        });

        // Add indexes to class_student_attendances table
        Schema::table('class_student_attendances', function (Blueprint $table) {
            $table->index('attendance_id');
            $table->index('student_id');
            $table->index(['attendance_id', 'student_id']);
        });

        // Add foreign keys to class_student_attendances table
        Schema::table('class_student_attendances', function (Blueprint $table) {
            $table->foreign('attendance_id')->references('id')->on('class_attendances')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Add indexes to class_fees table
        Schema::table('class_fees', function (Blueprint $table) {
            $table->index('class_id');
            $table->index('session_id');
            $table->index(['class_id', 'session_id']);
        });

        // Add foreign keys to class_fees table
        Schema::table('class_fees', function (Blueprint $table) {
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('school_sessions')->onDelete('cascade');
        });

        // Add indexes to class_student_fees table
        Schema::table('class_student_fees', function (Blueprint $table) {
            $table->index('class_fee_id');
            $table->index('student_id');
            $table->index('status');
            $table->index(['student_id', 'status']);
        });

        // Add foreign keys to class_student_fees table
        Schema::table('class_student_fees', function (Blueprint $table) {
            $table->foreign('class_fee_id')->references('id')->on('class_fees')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Add indexes to school_information table
        Schema::table('school_information', function (Blueprint $table) {
            $table->index('status');
            $table->index('parent_school_id');
            $table->index(['status', 'parent_school_id']);
        });

        // Add indexes to school_sessions table
        Schema::table('school_sessions', function (Blueprint $table) {
            $table->index('school_id');
            $table->index('status');
            $table->index(['school_id', 'status']);
        });

        // Add foreign keys to school_sessions table
        Schema::table('school_sessions', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('school_information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop foreign keys first
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['school_information_id']);
        });

        Schema::table('student_details', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['class_id']);
        });

        Schema::table('teacher_details', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['class_grade_id']);
            $table->dropForeign(['school_id']);
        });

        Schema::table('class_subjects', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropForeign(['subject_id']);
        });

        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['class_id']);
        });

        Schema::table('student_marks', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['assesment_id']);
        });

        Schema::table('student_assessments', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['class_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['type_id']);
            $table->dropForeign(['school_session_id']);
        });

        Schema::table('class_attendances', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['class_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['school_session_id']);
        });

        Schema::table('class_student_attendances', function (Blueprint $table) {
            $table->dropForeign(['attendance_id']);
            $table->dropForeign(['student_id']);
        });

        Schema::table('class_fees', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropForeign(['session_id']);
        });

        Schema::table('class_student_fees', function (Blueprint $table) {
            $table->dropForeign(['class_fee_id']);
            $table->dropForeign(['student_id']);
        });

        Schema::table('school_sessions', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        // Drop indexes
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['user_name']);
            $table->dropIndex(['role_id']);
            $table->dropIndex(['school_information_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['role_id', 'school_information_id']);
            $table->dropIndex(['status', 'school_information_id']);
        });

        Schema::table('student_details', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['class_id']);
            $table->dropIndex(['registration_id']);
            $table->dropIndex(['father_cnic']);
            $table->dropIndex(['phone']);
            $table->dropIndex(['class_id', 'deleted_at']);
        });

        Schema::table('teacher_details', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['cnic']);
            $table->dropIndex(['phone']);
            $table->dropIndex(['qualification']);
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->dropIndex(['class_grade_id']);
            $table->dropIndex(['school_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['school_id', 'status']);
        });

        Schema::table('class_subjects', function (Blueprint $table) {
            $table->dropIndex(['class_id']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['class_id', 'subject_id']);
        });

        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['class_id']);
            $table->dropIndex(['teacher_id', 'class_id']);
        });

        Schema::table('student_marks', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
            $table->dropIndex(['assesment_id']);
            $table->dropIndex(['student_id', 'assesment_id']);
        });

        Schema::table('student_assessments', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
            $table->dropIndex(['class_id']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['type_id']);
            $table->dropIndex(['school_session_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['class_id', 'subject_id', 'type_id']);
        });

        Schema::table('class_attendances', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
            $table->dropIndex(['class_id']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['school_session_id']);
            $table->dropIndex(['date']);
            $table->dropIndex(['class_id', 'subject_id', 'date']);
        });

        Schema::table('class_student_attendances', function (Blueprint $table) {
            $table->dropIndex(['attendance_id']);
            $table->dropIndex(['student_id']);
            $table->dropIndex(['attendance_id', 'student_id']);
        });

        Schema::table('class_fees', function (Blueprint $table) {
            $table->dropIndex(['class_id']);
            $table->dropIndex(['session_id']);
            $table->dropIndex(['class_id', 'session_id']);
        });

        Schema::table('class_student_fees', function (Blueprint $table) {
            $table->dropIndex(['class_fee_id']);
            $table->dropIndex(['student_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['student_id', 'status']);
        });

        Schema::table('school_information', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['parent_school_id']);
            $table->dropIndex(['status', 'parent_school_id']);
        });

        Schema::table('school_sessions', function (Blueprint $table) {
            $table->dropIndex(['school_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['school_id', 'status']);
        });
    }
}