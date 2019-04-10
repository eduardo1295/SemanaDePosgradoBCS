<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaConstancias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constancias', function (Blueprint $table) {
            $table->increments('id');
    
            $table->integer('creada_por')->unsigned();
            $table->foreign('creada_por')->references('id')->on('users');
            $table->integer('id_semana')->unsigned();
            $table->foreign('id_semana')->references('id_semana')->on('semanas');


            $table->string('titulo', 40);
            $table->string('cuerpo', 100);
            $table->string('url_imagen_fondo', 100)->nullable();

            $table->timestamps();
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
        Schema::dropIfExists('constancias');
    }
}
