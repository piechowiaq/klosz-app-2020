<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistriesTable extends Migration
{

    public function up()
    {
        Schema::create('registries', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('valid_for')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registries');
    }
}
