<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCarrusel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrusel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orden')->unsigned();
            $table->string('link_web', 60)->nullable()->default('Sin_url_asignada');
            $table->string('url_imagen', 100);

            $table->integer('creado_por')->unsigned();
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
        Schema::dropIfExists('carrusel');
    }
}
