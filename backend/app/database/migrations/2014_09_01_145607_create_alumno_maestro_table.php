<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlumnoMaestroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumno_maestro', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('alumno_id')->unsigned()->index();
			$table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
			$table->integer('maestro_id')->unsigned()->index();
			$table->foreign('maestro_id')->references('id')->on('maestros')->onDelete('cascade');
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
		Schema::drop('Alumno_Maestro');
	}

}
