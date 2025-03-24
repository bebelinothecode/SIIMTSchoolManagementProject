<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');   
            $table->foreign('student_id')->references('id')->on('students');
            $table->enum("document_type",["Transcript","Introduction Letter","Immigration Letter"]);
            $table->text('reason')->nullable();
            $table->enum("status",['pending','approved','rejected'])->default('pending');        
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
        Schema::dropIfExists('document_requests');
    }
}
