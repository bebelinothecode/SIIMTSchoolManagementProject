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
        Schema::table('teacher_subject', function (Blueprint $table) {
            $table->string('num_of_sessions')->nullable();
            $table->string('aca_prof')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_subject', function (Blueprint $table) {
            $table->dropColumn('num_of_sessions');
            $table->dropColumn('aca_prof');
        });
    }
};
