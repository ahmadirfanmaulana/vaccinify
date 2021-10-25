<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_id');
            $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('medicals')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['accepted', 'declined', 'pending'])->default('pending');
            $table->text('disease_history')->nullable();
            $table->text('current_symptoms')->nullable();
            $table->text('doctor_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
}
