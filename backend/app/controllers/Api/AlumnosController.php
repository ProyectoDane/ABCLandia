<?php

namespace Api;

use Alumno;
use Palabra;
use Illuminate\Support\Facades\Response;

class AlumnosController extends \BaseController
{
        public function index($id)
	{
		$alumno = Alumno::findOrFail($id);
                $palabras = Palabra::ByCategoria($alumno->categoria_id)->get();
                
                $alumno_dto = new \stdClass();
                
                $alumno_dto->id = $alumno->id;
                $alumno_dto->intervalo_entre_tarjetas = 30;
                $alumno_dto->tipo_letra = $alumno->tipo_letra;
                
                $alumno_dto->categoria = new \stdClass();
                $alumno_dto->categoria->id = $alumno->categoria_id;
                $alumno_dto->categoria->palabras = $palabras->map(function($e) { 
                    $e->palabra = mb_strtolower($e->palabra,'UTF-8');
                    return $e;
                });
                
                ob_end_clean();
		return Response::json($alumno_dto);
	}
        
	public function categoria($id)
	{
		$alumno = Alumno::findOrFail($id);
                $palabras = Palabra::ByCategoria($alumno->categoria_id)->get();
                ob_end_clean();
		return Response::json($palabras);
	}       
}
