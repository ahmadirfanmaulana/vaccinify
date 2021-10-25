<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('dose')->default(1);
            $table->date('date');
            $table->unsignedBigInteger('society_id');
            $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('spot_id')->nullable();
            $table->foreign('spot_id')->references('id')->on('spots')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('vaccine_id')->nullable();
            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('medicals')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('officer_id')->nullable();
            $table->foreign('officer_id')->references('id')->on('medicals')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccinations');
    }
}
