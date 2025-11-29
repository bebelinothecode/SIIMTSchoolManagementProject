<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEnquiryTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_enquires', function (Blueprint $table) {
            $table->enum("type_of_course",["Academic", "Professional"])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_enquires', function (Blueprint $table) {
            $table->dropColumn('type_of_course');
        });
    }
}
