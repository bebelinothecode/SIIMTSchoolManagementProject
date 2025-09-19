<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_enquires', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
 
            $table->foreign('course_id')->references('id')->on('grades')->onDelete('set null');

            $table->unsignedBigInteger('diploma_id')->nullable();

            $table->foreign('diploma_id')->references('id')->on('diploma')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_enquires', function (Blueprint $table) {
            //
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
            $table->dropForeign(['diploma_id']);
            $table->dropColumn('diploma_id');
        });
    }
};
