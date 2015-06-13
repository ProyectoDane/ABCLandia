<?php

class PalabrasController extends \BaseController {

        public function __construct()
        {
            $this->beforeFilter('csrf', array('only' => array('update')));
        }
        
	/**
	 * Display a listing of maestros
	 *
	 * @return Response
	 */
	public function index($categoria_id)
	{
		$palabras = Palabra::ByCategoria($categoria_id)->get();
                $result = array('status' => 'success', 'data' => $palabras);
		return Response::json($result);
	}

	/**
	 * Update the specified maestro in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($categoria_id, $letra)
	{
		$palabra = Palabra::get($letra, $categoria_id);

                $validator = Validator::make($data = Input::all(), Palabra::rules($letra));

		if($validator->fails())
                {
                    $result = array('status' => 'errors', 'data' => $validator->messages());
                }
                else
                {
                    $palabra->update($data);
                    $result = array('status' => 'success', 'data' => $palabra);
                }

                return Response::json($result);
	}

        public function imagen($categoria_id, $letra)
        {
                $palabra = Palabra::get($letra, $categoria_id);
                $imagen = $palabra->imagen()->first();
                ob_end_clean();
                return Response::make($imagen->data, 200, array('content-type' => 'image'));
        }
        
        public function sonido($categoria_id, $letra)
        {
                $palabra = Palabra::get($letra, $categoria_id);
                $sonido = $palabra->sonido()->first();
                ob_end_clean();
                return Response::make($sonido->mp3, 200, array('content-type' => 'audio/mpeg'));
        }
}
