<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('env_prestador');
            $table->foreign('env_prestador')->references('id')->on('prestadors')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('env_obrasocial');
            $table->foreign('env_obrasocial')->references('id')->on('obra_socials')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('env_afiliado');
            $table->foreign('env_afiliado')->references('id')->on('afiliados')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('env_usuario');
            $table->foreign('env_usuario')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('env_periodo')->nullable();
            $table->integer('env_prestacion')->nullable();
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
        Schema::dropIfExists('envios');
    }
}
