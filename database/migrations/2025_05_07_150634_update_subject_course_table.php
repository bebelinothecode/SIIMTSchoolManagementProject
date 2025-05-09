<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSubjectCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subject_course', function (Blueprint $table) {
            $table->string('level');
            $table->string('semester');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_course', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('level')->onDelete('cascade');
            $table->unsignedBigInteger('semester_id'); 
            $table->foreign('semester_id')->references('id')->on('session')->onDelete('cascade');     
        });
    }
}
