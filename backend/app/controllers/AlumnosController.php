<?php

use \Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Facades\Response;

class AlumnosController extends \BaseController {

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
                $esSupervisor = true;
            
		$alumnos_ = Alumno::with('maestros', 'categoria')->get();
                $alumnos = new Collection();
                foreach ($alumnos_ as $alumno)
                {
                    $alumnos->add($alumno->ToDto());
                }
                
                $maestros = Maestro::all(['id', 'nombre', 'apellido']);
                $categorias = Categoria::all(['id', 'nombre']);
                
                $edit_tpl   = json_encode(View::make('alumnos.edit', compact('esSupervisor'))->render());
                $create_tpl = json_encode(View::make('alumnos.create')->render());
		$delete_tpl = json_encode(View::make('layouts.delete')->render());
                
                $title = 'Todos los Alumnos';
                $show_new = true;
              
		return View::make('alumnos.index', compact('show_new', 'title', 'alumnos', 'maestros', 'categorias', 'edit_tpl', 'create_tpl', 'delete_tpl', 'esSupervisor'));
	}
        
        public function mios()
	{
                $user = Auth::user();
                $esSupervisor = $user->tipo === Maestro::SUPERVISOR;
                
		$alumnos_ = Alumno::whereHas('maestros', function($q) use ($user)
                {
                    $q->where('maestros.id', '=', $user->id);
                })->get();
                
                $alumnos = new Collection();
                foreach ($alumnos_ as $alumno)
                {
                    $alumnos->add($alumno->ToDto());
                }
              
                $categorias = Categoria::all(['id', 'nombre']);
                
                $title = 'Mis Alumnos';
                $show_new = false;
              
                if ($esSupervisor)
                {
                    $maestros = Maestro::all(['id', 'nombre', 'apellido']);
                    
                    $edit_tpl   = json_encode(View::make('alumnos.edit', compact('esSupervisor'))->render());
                    $create_tpl = json_encode(View::make('alumnos.create')->render());
                    $delete_tpl = json_encode(View::make('layouts.delete')->render());
                    
                    return View::make('alumnos.index', compact('show_new', 'title', 'alumnos', 'maestros', 'categorias', 'edit_tpl', 'create_tpl', 'delete_tpl', 'esSupervisor'));
                }
                else
                {
                    $edit_tpl   = json_encode(View::make('alumnos.edit', compact('esSupervisor'))->render());
                    
                    return View::make('alumnos.index', compact('show_new', 'title', 'alumnos', 'categorias', 'edit_tpl', 'esSupervisor'));
                }
	}

	/**
	 * Store a newly created maestro in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Alumno::create_rules());

                $result = $validator->fails()
                        ? array('status' => 'errors', 'data' => $validator->messages())
                        : array('status' => 'success', 'data' => Alumno::create($data)->ToDto());

                return Response::json($result);
	}

	/**
	 * Display the specified maestro.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$alumno = Alumno::findOrFail($id);

		return View::make('alumnos.show', compact('alumno'));
	}

	/**
	 * Update the specified maestro in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$alumno = Alumno::findOrFail($id);

                $validator = Validator::make($data = Input::all(), Alumno::update_rules($id));

                $result = $validator->fails()
                        ? array('status' => 'errors', 'data' => $validator->messages())
                        : array('status' => 'success', 'data' => $alumno->update($data)->ToDto());
                
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
		Alumno::destroy($id);
	}
}
