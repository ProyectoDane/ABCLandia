<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categorias', function(Blueprint $table)
		{
			$table->increments('id');
                        
                        $table->string('nombre');
                        $table->text('descripcion');
                        
                        $table->softDeletes();
			$table->timestamps();
                        
                        $table->integer('maestro_id')->unsigned()->index();			
                        $table->foreign('maestro_id')->references('id')->on('maestros'); 
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('categorias');
	}

}
