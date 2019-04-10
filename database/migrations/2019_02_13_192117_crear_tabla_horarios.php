<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaHorarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            //$table->increments('id_horario');

            $table->integer('id_locacion')->unsigned();
            //$table->foreign('id_locacion')->references('id_locacion')->on('locaciones');
            $table->integer('id_trabajo')->unsigned();
            $table->foreign('id_trabajo')->references('id_trabajo')->on('trabajos');
            $table->string('ubicacion', 30)->nullable();
            $table->date('dia');
            $table->date('hora');

            $table->integer('creado_por')->unsigned();
            //$table->foreign('creado_por')->references('id')->on('users');
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
        Schema::dropIfExists('horarios');
    }
}
