<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaLocacionModalidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacion_modalidad', function (Blueprint $table) {
            //$table->increments('id');
            
            $table->integer('id_locacion')->unsigned();
            $table->foreign('id_locacion')->references('id_locacion')->on('locaciones');
            $table->integer('id_modalidad')->unsigned();
            $table->foreign('id_modalidad')->references('id_modalidad')->on('modalidades');
            
            $table->integer('creado_por')->unsigned();
            $table->foreign('creado_por')->references('id')->on('users');
            $table->timestamp('fecha_creacion')->nullable();
            $table->integer('actualizado_por')->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();

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
        Schema::dropIfExists('locacion_modalidad');
    }
}
