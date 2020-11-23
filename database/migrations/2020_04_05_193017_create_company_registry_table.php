<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyRegistryTable extends Migration
{

    public function up()
    {
        Schema::create('company_registry', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('registry_id');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('registry_id')->references('id')->on('registries')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_registry');
    }
}
