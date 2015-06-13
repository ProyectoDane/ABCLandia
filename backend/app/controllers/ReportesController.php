<?php

use \Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Facades\Response;

class ReportesController extends \BaseController {

	/**
	 * Display a listing of maestros
	 *
	 * @return Response
	 */
	public function index()
	{
                $esSupervisor = Auth::user()->tipo === Maestro::SUPERVISOR;
            
		$alumnos_ = Alumno::with('maestros')->get();
                $alumnos = new Collection();
                //$alumnos->add(['id' => '0', 'nombre' => 'TODOS']);
                foreach ($alumnos_ as $alumno)
                {
                    $alumnos->add($alumno->ToDto());
                }
                
                $maestros = new Collection();
                $maestros->add(['id' => '0', 'nombre' => 'TODOS']);
                foreach (Maestro::all(['id', 'nombre', 'apellido']) as $maestro)
                        $maestros->add($maestro);

                $categorias = new Collection();
                $categorias->add(['id' => '0', 'nombre' => 'TODOS']);
                foreach (Categoria::all(['id', 'nombre']) as $categoria)
                        $categorias->add($categoria);
                
		return View::make('reportes.index', compact('alumnos', 'maestros', 'categorias', 'esSupervisor'));
	}
}
