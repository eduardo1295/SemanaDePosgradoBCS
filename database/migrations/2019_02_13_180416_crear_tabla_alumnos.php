<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAlumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('users');
            $table->integer('id_programa')->unsigned();
            //$table->foreign('id_programa')->references('id')->on('programas');

            $table->integer('id_director')->unsigned();
            $table->foreign('id_director')->references('id')->on('directores_tesis');

            $table->string('num_control', 15)->unique();
            $table->decimal('semestre',10,0);
            $table->boolean('constancia_generada')->default(false);
            $table->timestamp('fecha_constancia')->nullable();
            $table->boolean('gafete_generado')->default(false);
            $table->timestamp('fecha_gafete')->nullable();

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
        Schema::dropIfExists('alumnos');
    }
}
