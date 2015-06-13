<?php

namespace Api;

use Imagen;
use Illuminate\Support\Facades\Response;

class ImagenesController extends \BaseController
{
	public function show($id)
        {
                $imagen = Imagen::findOrFail($id);
                $data = base64_encode($imagen->data);
                ob_end_clean();
                return Response::json($data);
        }
}
