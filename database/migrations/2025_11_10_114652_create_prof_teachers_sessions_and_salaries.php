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
        Schema::create('prof_teachers_sessions_and_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teaceher_id');
            $table->foreign('teaceher_id')->references('id')->on('teachers');
            $table->unsignedBigInteger('diploma_id');
            $table->foreign('diploma_id')->references('id')->on('diploma');
            $table->enum('session_type', ['weekday', 'weekend', 'online'])->nullable();
            $table->enum('amount_per_session', ['weekend', 'weekday','online'])->nullable();
            $table->integer('total_salary')->nullable();
            $table->double('with_holding_tax')->default(0.03);
            $table->integer('amount_after_tax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prof_teachers_sessions_and_salaries');
    }
};
