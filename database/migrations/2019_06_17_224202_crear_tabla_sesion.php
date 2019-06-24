<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSesion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sesiones', function (Blueprint $table) {
            $table->increments('id_sesion');
            $table->int('id_modalidad');
            $table->string('nombre', 50);
            $table->date('dia', 15);
            $table->time('hora_inicio', 15);
            $table->time('hora_fin', 15);
            $table->int('cantidad');
            $table->string('lugar', 100);

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
        Schema::dropIfExists('sesiones');
    }
}
