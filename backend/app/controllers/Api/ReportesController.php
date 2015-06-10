<?php

namespace Api;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class ReportesController extends \BaseController
{
	public function index()
	{
                $rules = [
                        'metrica'       => 'required',
                        'desde'         => 'required | fecha',
                        'hasta'         => 'required | fecha',
                        'alumnos'       => 'required | minCount:1',
                        'categoria_id'  => 'required',
                        'ejercicio'     => 'required',
                        'nivel'         => 'required'
                ];
                
                if (\Auth::user()->tipo == \Maestro::SUPERVISOR)
                {
                    $rules['maestros'] = 'required';
                }
                
                $validator = \Validator::make(Input::all(), $rules);
                
                if ($validator->fails())
                {
                    return Response::json(array('status' => 'errors', 'data' => $validator->messages()));
                }

                $query = \DB::table('rendimientos')
                    ->whereIn('alumno_id', Input::get('alumnos'));
                
                if ($maestro = Input::get('maestros'))
                {
                    $query = $query->where('maestro_id', $maestro);
                }
                
                if ($categoria = Input::get('cateogia_id'))
                {
                    $query = $query->where('categoria_id', $categoria);
                }
                
                if ($ejercicio = Input::get('ejercicio'))
                {
                    $query = $query->where('ejercicio', $ejercicio);
                }
                
                if ($nivel = Input::get('nivel'))
                {
                    $query = $query->where('nivel', $nivel);
                }
                
                preg_match('$(\d{2})/(\d{2})/(\d{4})$', Input::get('desde'), $matches);
                $query->whereRaw("timestamp >= '" . $matches[3].'-'.$matches[2].'-'.$matches[1]. ' 00:00:00' . "'");
                
                preg_match('$(\d{2})/(\d{2})/(\d{4})$', Input::get('hasta'), $matches);
                $query->whereRaw("timestamp <= '" . $matches[3].'-'.$matches[2].'-'.$matches[1]. ' 23:59:59' . "'");
                
                switch ($periodo = Input::get('periodo'))
                {
                    case '1' :
                        $query = $query->whereRaw("DATEDIFF('".date("Y-m-d H:i:s")."', timestamp) < 30 AND timestamp < '".date("Y-m-d H:i:s")."'");
                        break;
                    case '2' :
                        $query = $query->whereRaw("DATEDIFF('".date("Y-m-d H:i:s")."', timestamp) < 7 AND timestamp < '".date("Y-m-d H:i:s")."'");
                        break;
                    case '3' :
                        $query = $query->whereRaw("DATEDIFF('".date("Y-m-d H:i:s")."', timestamp) < 365 AND timestamp < '".date("Y-m-d H:i:s")."'");
                        break;
                    case '4' : break;
                    case '5' : break;
                }
                
                switch ($metrica = Input::get('metrica'))
                {
                    case '1' :
                        $metrica = 'cantidad_fallas';
                        break;
                    case '2' :
                        $metrica = 'round(tiempo / 1000)';
                        break;
                    case '3' :
                        $metrica = 'cantidad_fallas * round(tiempo / 1000)';
                        break;
                }
                
                $results = $query
                    ->groupBy('date', 'alumno_id')
                    ->select(\DB::raw('avg('.$metrica.') as metrica, DATE(timestamp) as date, alumno_id'))
                    ->orderBy('alumno_id')
                    ->orderBy('timestamp')
                    ->get();

                //$queries = \DB::getQueryLog();
                //$last_query = end($queries);
                //return Response::json($last_query);
                //var_dump($results);
                $response = [];
                
                $i = 0;
                while ($i < count($results))
                {
                    $alumno_id = $results[$i]->alumno_id;
                    
                    $data = [];
                    
                    while ($i < count($results) && $alumno_id == $results[$i]->alumno_id)
                    {
                        $data[] = $results[$i];
                        $i++;
                    }
                    
                    $alumno = \Alumno::find($alumno_id);
                    
                    $response[] = [
                        'alumno_id'         => $alumno_id,
                        'alumno_nombre'     => $alumno->nombre,
                        'alumno_apellido'   => $alumno->apellido,
                        'data'              => $data
                    ];
                }

		return Response::json($response);
	}       
}