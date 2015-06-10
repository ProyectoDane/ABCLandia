<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRendimientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rendimientos', function(Blueprint $table)
		{
			$table->increments('id');
                        
                        $table->integer('alumno_id')->unsigned()->index();
                        $table->integer('maestro_id')->unsigned()->index();
                        $table->integer('categoria_id')->unsigned()->index();
                        
                        $table->integer('ejercicio')->unsigned()->index();
                        $table->integer('nivel')->unsigned()->index();
                        $table->string('secuencia')->index();
                        
                        $table->integer('tiempo')->unsigned();
                        $table->integer('cantidad_aciertos')->unsigned();
                        $table->integer('cantidad_fallas')->unsigned();
                        
                        $table->foreign('alumno_id')->references('id')->on('alumnos');
                        $table->foreign('maestro_id')->references('id')->on('maestros');
                        $table->foreign('categoria_id')->references('id')->on('categorias');
                        
			$table->dateTime('timestamp');
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
		Schema::drop('rendimientos');
	}

}
