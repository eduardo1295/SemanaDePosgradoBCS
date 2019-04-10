<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaNoticias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->increments('id_noticia');
            $table->string('titulo', 100);
            $table->string('resumen', 100);
            $table->text('contenido');
            $table->string('url_imagen', 100)->nullable();

            $table->integer('creada_por')->unsigned();
            //$table->foreign('creada_por')->references('id')->on('users');
            $table->timestamp('fecha_creacion')->nullable();
            $table->integer('actualizado_por')->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();
            
            $table->softDeletes();
            
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
        Schema::dropIfExists('noticias');
    }
}
