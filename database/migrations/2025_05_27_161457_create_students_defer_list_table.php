<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsDeferListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_defer_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('grades');
            $table->unsignedBigInteger('course_id_prof')->nullable();
            $table->foreign('course_id_prof')->references('id')->on('diploma');
            $table->string('gender')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('current_address')->nullable();
            $table->string('student_type')->nullable();
            $table->string('index_number')->nullable();
            $table->string('academicyear')->nullable();
            $table->string('session')->nullable();
            $table->string('student_category')->nullable();
            $table->string('attendance_time')->nullable();
            $table->string('fees')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_prof')->nullable();
            $table->string('student_parent')->nullable();
            $table->string('parent_phonenumber')->nullable();
            $table->string('fees_prof')->nullable();
            $table->string('duration_prof')->nullable();
            $table->string('level')->nullable();
            $table->string('Scholarship')->nullable();
            $table->string('Scholarship_amount')->nullable();
            $table->string('status')->nullable();
            $table->string('balance')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('students_defer_list');
    }
}
