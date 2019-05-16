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
            $table->string('nombre', 100);
            $table->string('desc_general', 1000);
            $table->string('url_logo',100)->nullable();
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
