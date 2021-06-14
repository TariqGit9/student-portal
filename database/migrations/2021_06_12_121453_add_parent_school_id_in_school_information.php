<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentSchoolIdInSchoolInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_information', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_school_id')->nullable()->after('school_unique_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_information', function (Blueprint $table) {
            $table->dropColumn('parent_school_id');
        });
    }
}
