<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
                DB::Statement("SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO'");

                $this->call('LetrasTableSeeder');
		$this->call('MaestrosTableSeeder');
                $this->call('CategoriasTableSeeder');
                $this->call('ImagenesTableSeeder');
                $this->call('SonidosTableSeeder');
                $this->call('PalabrasTableSeeder');
	}

}
