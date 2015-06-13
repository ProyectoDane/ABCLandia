<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaestrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('maestros', function(Blueprint $table)
		{
			$table->increments('id');
                        
                        $table->string('email');
                        $table->string('password');
                        $table->string('nombre');
                        $table->string('apellido');
                        $table->integer('tipo');
                        $table->string('token')->nullable();
                        
                        $table->rememberToken();
                        
                        $table->softDeletes();
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
		Schema::drop('maestros');
	}

}
