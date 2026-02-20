<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('sender_id');
            $table->string('title');
            $table->text('message');
            $table->string('target_audience'); // admin, teacher, student, teacher_and_student
            $table->date('expiry_date');
            $table->tinyInteger('status')->default(1);
            $table->string('ip_address')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('school_information')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['school_id', 'target_audience', 'expiry_date', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
