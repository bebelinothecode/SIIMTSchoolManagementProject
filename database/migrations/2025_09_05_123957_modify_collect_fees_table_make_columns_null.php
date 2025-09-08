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
        Schema::table('collect_fees', function (Blueprint $table) {
            $table->string('student_index_number')->nullable()->change();
            $table->string('student_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collect_fees', function (Blueprint $table) {
            //
            $table->string('student_index_number')->nullable(false)->change();
            $table->string('student_name')->nullable(false)->change();
        });
    }
};
