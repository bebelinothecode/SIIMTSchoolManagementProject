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
      Schema::create('teacher_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->string('receipt_number')->unique();
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('withholding_tax', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2);
            $table->string('method')->nullable();
            $table->json('session_ids')->nullable(); // store referenced teaching_session ids
            $table->dateTime('paid_at');
            $table->timestamps();
            $table->index(['teacher_id','paid_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_payments');
    }
};
