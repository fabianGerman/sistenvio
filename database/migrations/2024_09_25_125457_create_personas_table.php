<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('per_documento')->nullable();
            $table->string('per_nombres')->nullable();
            $table->string('per_instituto')->nullable();
            $table->string('per_direccion')->nullable();
            $table->string('per_telefono')->nullable();
            $table->unsignedBigInteger('per_usuario');
            $table->foreign('per_usuario')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('personas');
    }
}
