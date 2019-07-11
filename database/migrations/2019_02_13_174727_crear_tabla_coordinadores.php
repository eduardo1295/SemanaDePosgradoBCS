<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCoordinadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinadores', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('users');
            //$table->integer('id_semana')->unsigned();
            //$table->foreign('id_semana')->references('id_semana')->on('semanas');

            $table->string('puesto', 60);
            //$table->string('grado', 30);

            $table->engine = 'InnoDB';
            $table->collation = 'latin1_swedish_ci';
            $table->charset = 'latin1';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinadores');
    }
}
