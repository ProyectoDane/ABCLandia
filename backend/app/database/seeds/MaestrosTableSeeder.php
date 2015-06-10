<?php

class MaestrosTableSeeder extends Seeder {

	public function run()
	{
                Maestro::create([
                    'nombre'        => 'dummy', 
                    'apellido'      => 'dummy',
                    'email'         => 'dummy@dummy.com',
                    'password'      => Hash::make('dummy'),
                    'tipo'          => Maestro::SUPERVISOR
                ]);
                
                DB::statement('UPDATE maestros SET deleted_at = NOW()');
                
                Maestro::create([
                    'nombre'        => 'Test', 
                    'apellido'      => 'Supervisor',
                    'email'         => 'test@supervisor.com',
                    'password'      => Hash::make('test'),
                    'tipo'          => Maestro::SUPERVISOR
                ]);
                
                Maestro::create([
                    'nombre'        => 'Test', 
                    'apellido'      => 'Maestro',
                    'email'         => 'test@maestro.com',
                    'password'      => Hash::make('test'),
                    'tipo'          => Maestro::MAESTRO
                ]);
	}

}