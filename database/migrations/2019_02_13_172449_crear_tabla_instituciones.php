<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaInstituciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituciones', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('id_institucion', 15)->unique();

            //$table->integer('id_semana')->unsigned()->default(0);

            $table->string('nombre', 100);
            $table->string('siglas', 100);
            $table->string('telefono', 20)->nullable();
            $table->string('ciudad', 30)->nullable();
            $table->string('calle', 30)->nullable();
            $table->string('numero', 5)->nullable();
            $table->string('colonia', 30)->nullable();
            $table->string('cp', 10)->nullable();
            $table->string('direccion_web', 100)->nullable();
            $table->string('url_logo', 100)->nullable();
            $table->boolean('req_horas_minimas')->default(false);
            $table->integer('horas_minimas')->nullable();
            $table->double('latitud')->default(0);
            $table->double('longitud')->default(0);
            $table->boolean('sede')->default(false);
            
            $table->integer('creado_por');
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
        Schema::dropIfExists('instituciones');
    }
}
