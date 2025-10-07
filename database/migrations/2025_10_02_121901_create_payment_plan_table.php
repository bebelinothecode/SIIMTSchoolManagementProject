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
        Schema::create('payment_plan', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_fees_due', 12, 2);
            $table->decimal('amount_already_paid', 12, 2);
            $table->decimal('outstanding_balance', 12, 2);
            $table->string('currency');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_plan');
    }
};
