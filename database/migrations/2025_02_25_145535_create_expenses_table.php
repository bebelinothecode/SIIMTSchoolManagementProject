<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->enum("source_of_expense",["Academic", "Professional"]);
            $table->text("description_of_expense");
            $table->string("category");
            $table->enum("currency",["Dollar", "Ghana Cedi"]);
            $table->double("amount",10, 2);
            $table->string("mode_of_payment");
            $table->string("mobile_money_details")->nullable();
            $table->string("cash_details")->nullable();
            $table->string("bank_details")->nullable();
            $table->string("cheque_details")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
