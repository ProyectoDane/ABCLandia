<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlumnosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumnos', function(Blueprint $table)
		{
			$table->increments('id');
                        
                        $table->string('nombre');
                        $table->string('apellido');
                        $table->integer('edad');
                        $table->integer('sexo');
                        
                        $table->softDeletes();
			$table->timestamps();
                        
                        // CONFIGURACION
                        $table->integer('categoria_id')->unsigned()->index();			
                        $table->foreign('categoria_id')->references('id')->on('categorias');   
                        
                        $table->integer('tipo_letra')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Alumnos');
	}

}
