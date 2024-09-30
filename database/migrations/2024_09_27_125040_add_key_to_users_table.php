<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeyToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('rol_usuario')->nullable();
            $table->unsignedBigInteger('area_usuario')->nullable();
            $table->foreign('rol_usuario')->references('id')->on('rols')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('area_usuario')->references('id')->on('areas')->onDelete('cascade')->onUpdate('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar las claves foráneas
            $table->dropForeign(['rol_usuario']);
            $table->dropForeign(['area_usuario']);

            // Eliminar las columnas
            $table->dropColumn('rol_usuario');
            $table->dropColumn('area_usuario');
        });
    }
}
