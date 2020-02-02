<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_training', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('training_id');
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();

            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_training');
    }
}
