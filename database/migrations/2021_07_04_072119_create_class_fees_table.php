<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_fees', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();

            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('school_session_id')->nullable();

            
            $table->string('date')->nullable();
            $table->string('expiry_date')->nullable();
             
            $table->unsignedBigInteger('class_id')->nullable();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');

            $table->double('fee_charge', 15, 8);
            $table->double('late_fee_charge', 15, 8);


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
        Schema::dropIfExists('class_fees');
    }
}
