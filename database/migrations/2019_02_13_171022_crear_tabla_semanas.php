<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSemanas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semanas', function (Blueprint $table) {
            $table->increments('id_semana');
            $table->integer('id_sede')->unsigned();
            $table->foreign('id_sede')->references('id')->on('instituciones');
            $table->string('nombre', 100);
            $table->text('desc_general');
            $table->string('url_logo',100)->nullable();
            $table->string('url_convocatoria',100)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            
            $table->boolean('vigente')->default(false);
            
            $table->timestamp('fecha_creacion')->nullable();
            $table->integer('creado_por');
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->integer('actualizado_por')->nullable();
            
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
        Schema::dropIfExists('semanas');
    }
}
