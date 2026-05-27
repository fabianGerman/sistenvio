<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAtributePrestadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prestadors', function (Blueprint $table) {
            $table->string('prest_telefono')->nullable();
            $table->string('prest_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prestadors', function (Blueprint $table) {
            $table->dropColumn('prest_telefono');
            $table->dropColumn('prest_email');
        });
    }
}
