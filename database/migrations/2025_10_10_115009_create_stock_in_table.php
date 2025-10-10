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
        Schema::create('stock_in', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->integer('new_stock_in_quantity');
            $table->integer('old_stock_in_quantity');
            $table->integer('total_stock_after_in');
            $table->text('notes')->nullable();
            $table->foreign('stock_id')->references('id')->on('stock')->onDelete('cascade');
            $table->date('date_in');
            $table->text('suppliers_info')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
};
