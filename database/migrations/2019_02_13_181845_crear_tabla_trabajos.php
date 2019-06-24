<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTrabajos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->increments('id_trabajo');
            
            $table->integer('id_alumno')->unsigned();
            $table->foreign('id_alumno')->references('id')->on('users');
            $table->integer('id_director')->unsigned();
            $table->foreign('id_director')->references('id')->on('users');
            $table->integer('id_semana')->unsigned();
            $table->foreign('id_semana')->references('id_semana')->on('semanas');

            $table->string('titulo', 100);
            $table->string('resumen', 1000);
            $table->string('area', 100);
            $table->string('pal_clv1', 15);
            $table->string('pal_clv2', 15);
            $table->string('pal_clv3', 15);
            $table->string('pal_clv4', 15);
            $table->string('pal_clv5', 15);
            $table->string('Modalidad', 15);
            $table->datetime('fecha_entrega')->nullable();
            $table->string('comentario', 100)->nullable();
            $table->boolean('autorizado')->default(false);
            $table->boolean('revisado')->default(false);
            $table->boolean('constancia')->default(false);

            $table->timestamp('fecha_autorizacion')->nullable();
            $table->string('url', 100);

            $table->timestamp('fecha_creacion')->nullable();
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
        Schema::dropIfExists('trabajos');
    }
}
