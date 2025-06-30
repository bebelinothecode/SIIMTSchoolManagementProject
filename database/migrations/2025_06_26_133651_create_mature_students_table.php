<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatureStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mature_students', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->date('date_of_birth');
            $table->string('amount_paid');
            $table->string('mature_index_number');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('grades');
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
        Schema::dropIfExists('mature_students');
    }
}
