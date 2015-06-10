<?php

class MaestrosController extends \BaseController {

        private $mailer;
        
        public function __construct(IMailer $mailer)
        {
            $this->mailer = $mailer;
            
            $this->beforeFilter('csrf', array('only' => array('store', 'update', 'destroy')));
        }
        
	/**
	 * Display a listing of maestros
	 *
	 * @return Response
	 */
	public function index()
	{
		$maestros = Maestro::all();
                
                $edit_tpl   = json_encode(View::make('maestros.edit')->render());
                $create_tpl = json_encode(View::make('maestros.create')->render());
		$delete_tpl = json_encode(View::make('layouts.delete')->render());
                $alert_tpl = json_encode(View::make('layouts.alert')->render());

		return View::make('maestros.index', compact('maestros', 'edit_tpl', 'create_tpl', 'delete_tpl', 'alert_tpl'));
	}

	/**
	 * Store a newly created maestro in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
                $rules = Maestro::$rules;
                $rules['email'] .= '|unique:maestros,email,NULL,id,deleted_at,NULL';
                $rules['nombre'] .= '|unique_with:maestros,apellido';
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
                {
                    $result = array('status' => 'errors', 'data' => $validator->messages());
                }
                else
                {
                    $maestro = Maestro::create($data);
                    
                    $password = str_random(10);
                    $maestro->password = Hash::make($password);
                    $maestro->save();
                    
                    $this->mailer->send($maestro->email, 'Bienvenido a ABCLandia', 'account.email.welcome', ['nombre' => $maestro->nombre, 'password' => $password]);
                
                    $result = array('status' => 'success', 'data' => $maestro);
                }
		
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
		$maestro = Maestro::findOrFail($id);

		return View::make('maestros.show', compact('maestro'));
	}

	/**
	 * Update the specified maestro in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$maestro = Maestro::findOrFail($id);

                $rules = Maestro::$rules;
                $rules['email'] .= '|unique:maestros,email,' . $id . ',id,deleted_at,NULL';
                $rules['nombre'] .= '|unique_with:maestros,apellido,'.$id;
                $validator = Validator::make($data = Input::all(), $rules);

		if($validator->fails())
                {
                    $result = array('status' => 'errors', 'data' => $validator->messages());
                }
                else
                {
                    $maestro->update($data);
                    $result = array('status' => 'success', 'data' => $maestro);
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
                $alumnos = Maestro::findOrFail($id)->alumnos;
                
                if ($alumnos->count() > 0)
                {
                    $alumnos_str = '';
                    $prefix = '';
                    
                    foreach ($alumnos as $alumno)
                    {
                        $alumnos_str .= $prefix . $alumno->nombre . ' ' . $alumno->apellido;
                        $prefix = ', ';
                    }
                    return Response::json(['status' => 'error', 'msg' => 'El maestro no puede ser eliminado porque está asociada a los alumnos: ' . $alumnos_str]);
                }
                else
                {
                    Maestro::destroy($id);
                    return Response::json(['status' => 'success']);
                }
	}

}
