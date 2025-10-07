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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->date('due_date');
            $table->decimal('amount', 5, 2);
            $table->string('currency');
            $table->string('payment_method');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('payment_plan_id');
            $table->foreign('payment_plan_id')->references('id')->on('payment_plan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
