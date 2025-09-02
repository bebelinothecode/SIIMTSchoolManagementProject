<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerEvaluationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturer_evaluation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submission_id'); 
            $table->string('subject_code');
            $table->string('subject_name');
            $table->string('lecturer_name');
            $table->tinyInteger('clarity')->check('clarity between 1 and 5');
            $table->tinyInteger('knowledge')->check('knowledge between 1 and 5');
            $table->tinyInteger('punctuality')->check('punctuality between 1 and 5');
            $table->text('comments')->nullable();

            $table->foreign('submission_id')
                  ->references('id')->on('lecturer_evaluation_submissions')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('lecturer_evaluation_details');
    }
}
