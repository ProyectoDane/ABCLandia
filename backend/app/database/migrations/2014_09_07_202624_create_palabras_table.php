<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePalabrasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('palabras', function(Blueprint $table)
		{
                        $table->increments('id');
                        
                        $table->integer('categoria_id')->unsigned()->index();
                        $table->char('letra', 1);
			$table->string('palabra');
                        $table->integer('imagen_id')->nullable()->unsigned()->index();
                        $table->integer('sonido_id')->nullable()->unsigned()->index();
                        
                        $table->softDeletes();
			$table->timestamps();
                        
                        $table->foreign('categoria_id')->references('id')->on('categorias');
                        $table->foreign('imagen_id')->references('id')->on('imagenes')->onDelete('cascade');
                        $table->foreign('sonido_id')->references('id')->on('sonidos')->onDelete('cascade');
                });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('palabras');
	}

}
