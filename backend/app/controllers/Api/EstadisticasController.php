<?php

namespace Api;

use Rendimiento;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class EstadisticasController extends \Controller
{        
        public function feed()
        {
                $data = (array) json_decode(Input::get('estadisticas'));
                
                ob_start();
                var_dump($data);
                $result = ob_get_clean();
                \Log::info($result);
                \Log::info(Input::get('estadisticas'));
                /*
                $validator = Validator::make($data, Rendimiento::$rules);

                if ($validator->fails())
                {
                        $result = array('status' => 'errors', 'data' => $validator->messages());
                }
                else
                {*/
                        Rendimiento::create($data);
                        $result = array('status' => 'success');
                //}
                \Log::info($result);
                return Response::json($result);
        }
        
	public function show()
	{
		return Response::json(Rendimiento::all());
	}
}
