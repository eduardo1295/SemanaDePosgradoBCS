<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_institucion', 15)->nullable();
            $table->string('email', 60)->unique();
            $table->string('password', 60);
            $table->string('nombre', 40);
            $table->string('primer_apellido', 30);
            $table->string('segundo_apellido', 30)->nullable();
            //$table->integer('id_semana')->unsigned()->default(0);
            $table->timestamp('fecha_creacion')->nullable();
            $table->integer('creado_por')->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->integer('actualizado_por')->nullable();
            $table->timestamp('primerContrasena')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
