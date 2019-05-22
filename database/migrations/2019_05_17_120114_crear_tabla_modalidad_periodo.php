<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaModalidadPeriodo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modalidad_periodo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_posgrado')->unsigned();
            $table->foreign('id_posgrado')->references('id')->on('modalidad_posgrado');
            $table->integer('periodo_min');
            $table->integer('periodo_max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modalidad_periodo');
    }
}
