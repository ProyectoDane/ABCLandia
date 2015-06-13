<?php

namespace Api;

use Sonido;
use Illuminate\Support\Facades\Response;

class SonidosController extends \BaseController
{
	public function show($id)
        {
                $sonido = Sonido::findOrFail($id);
                $data = base64_encode($sonido->ogg);
                ob_end_clean();
                return Response::json($data);
        }
}
