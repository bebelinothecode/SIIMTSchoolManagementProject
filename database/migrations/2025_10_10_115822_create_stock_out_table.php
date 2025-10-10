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
        Schema::create('stock_out', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->integer('quantity_issued');
            $table->integer('initial_quantity');
            $table->integer('remaining_quantity');
            $table->string('issued_to')->nullable();
            $table->text('notes')->nullable();
            $table->date('date_issued')->nullable();
            $table->date('date_returned')->nullable();
            $table->foreign('stock_id')->references('id')->on('stock')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_out');
    }
};
