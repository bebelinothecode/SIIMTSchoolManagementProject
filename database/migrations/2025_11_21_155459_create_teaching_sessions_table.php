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
        Schema::create('teaching_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('diploma_id')->nullable();
            $table->date('session_date');
            $table->string('session_type')->nullable(); // weekday/weekend/online
            $table->decimal('amount_per_session', 10, 2)->default(0);
            $table->string('status')->default('completed');
            $table->timestamps();
            $table->index(['teacher_id','diploma_id','session_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaching_sessions');
    }
};
