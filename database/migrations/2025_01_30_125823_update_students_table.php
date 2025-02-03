<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('fees')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_prof')->nullable();
            $table->string('balance')->nullable();
            $table->string('student_parent')->nullable();
            $table->string('parent_phonenumber')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();    //Academic courses
            $table->foreign('course_id')->references('id')->on('grades');
            $table->unsignedBigInteger('course_id_prof')->nullable();    //Dilpoma/Professional courses
            $table->foreign('course_id_prof')->references('id')->on('diploma');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
}
