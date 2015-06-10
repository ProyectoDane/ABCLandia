<?php

use \Illuminate\Database\Eloquent\Collection;

class CategoriasController extends \BaseController {

        public function __construct()
        {
            $this->beforeFilter('csrf', array('only' => array('store', 'update', 'destroy')));
        }
        
	/**
	 * Display a listing of maestros
	 *
	 * @return Response
	 */
	public function index()
	{       
		$categorias_ = Categoria::all();
                $categorias = new Collection();
                foreach ($categorias_ as $categoria)
                {
                    $categorias->add($categoria->ToDto());
                }
                
                $edit_tpl   = json_encode(View::make('categorias.edit')->render());
                $create_tpl = json_encode(View::make('categorias.create')->render());
		$delete_tpl = json_encode(View::make('layouts.delete')->render());
                $alert_tpl = json_encode(View::make('layouts.alert')->render());
                
                $palabras_tpl = json_encode(View::make('palabras.index')->render());
                $palabras_edit_tpl = json_encode(View::make('palabras.edit')->render());

                return View::make('categorias.index', compact('categorias', 'edit_tpl', 'create_tpl', 'delete_tpl', 'alert_tpl', 'palabras_tpl', 'palabras_edit_tpl'));
	}

	/**
	 * Store a newly created maestro in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
                $data = Input::all();
                $data['maestro_id'] = Auth::user()->id;
                
                $rules = Categoria::$rules;
                $rules['nombre'] .= '|unique:categorias,nombre,NULL,id,deleted_at,NULL';
		$validator = Validator::make($data, $rules);

		$result = $validator->fails()
                    ? array('status' => 'errors', 'data' => $validator->messages())
                    : array('status' => 'success', 'data' => Categoria::create($data)->ToDto());
		
                return Response::json($result);
	}

	/**
	 * Update the specified maestro in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$categoria = Categoria::findOrFail($id);

                $rules = Categoria::$rules;
                $rules['nombre'] .= '|unique:categorias,nombre,' . $id . ',id,deleted_at,NULL';
                $validator = Validator::make($data = Input::all(), $rules);

		if($validator->fails())
                {
                    $result = array('status' => 'errors', 'data' => $validator->messages());
                }
                else
                {
                    $categoria->update($data);
                    $result = array('status' => 'success', 'data' => $categoria->ToDto());
                }

                return Response::json($result);
	}

	/**
	 * Remove the specified maestro from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
                $alumnos = Categoria::findOrFail($id)->alumnos;
                
                if ($alumnos->count() > 0)
                {
                    $alumnos_str = '';
                    $prefix = '';
                    
                    foreach ($alumnos as $alumno)
                    {
                        $alumnos_str .= $prefix . $alumno->nombre . ' ' . $alumno->apellido;
                        $prefix = ', ';
                    }
                    return Response::json(['status' => 'error', 'msg' => 'La categoría no puede ser eliminada porque está asociada a los alumnos: ' . $alumnos_str]);
                }
                else
                {
                    Categoria::destroy($id);
                    return Response::json(['status' => 'success']);
                }
	}
        
        public function copy($id)
	{
		$categoria = Categoria::findOrFail($id);
                
		$result = array('status' => 'success', 'data' => Categoria::copy($categoria)->ToDto());
		
                return Response::json($result);
	}

}
