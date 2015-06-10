<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSonidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sonidos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
		});
                
                DB::statement("ALTER TABLE sonidos ADD mp3 LONGBLOB");
                DB::statement("ALTER TABLE sonidos ADD ogg LONGBLOB");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sonidos');
	}

}
