<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaModalidadNivel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modalidad_nivel', function (Blueprint $table) {
            $table->integer('id_modalidad')->unsigned();
            $table->foreign('id_modalidad')->references('id_modalidad')->on('modalidades');
            $table->integer('id_nivel')->unsigned();
            $table->foreign('id_nivel')->references('id')->on('niveles');

            $table->integer('creada_por')->unsigned();
            $table->foreign('creada_por')->references('id')->on('users');
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
        Schema::dropIfExists('modalidad_nivel');
    }
}
