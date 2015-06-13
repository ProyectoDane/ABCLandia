<?php

namespace Api;

use Maestro;
use Illuminate\Support\Facades\Response;

class MaestrosController extends \BaseController
{
	public function index()
	{
		$maestros = Maestro::all(['id', 'nombre', 'apellido']);
		ob_end_clean();
                return Response::json($maestros);
        }

	public function alumnos($id)
	{
		$maestro = Maestro::findOrFail($id);
                $alumnos = $maestro->alumnos()->get(['alumnos.id', 'alumnos.nombre', 'alumnos.apellido']);
		ob_end_clean();
		return Response::json($alumnos);
	}       
}
