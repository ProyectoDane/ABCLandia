<?php

class AccountController extends \BaseController
{
        public function __construct()
        {
            $this->beforeFilter('csrf', array('only' => array('password')));
        }
        
	public function index()
	{
            return View::make('account.index')->with('msg', '');
	}
        
        public function password()
	{
            $user = Auth::user();
            
            if (!Hash::check(Input::get('current'), $user->password))
            {
                return View::make('account.index')->with('msg', 'Contraseña incorrecta');
            }
            
            if (strlen(Input::get('new')) < 6)
            {
                return View::make('account.index')->with('msg', 'La nueva contraseña debe tener al menos 6 caracteres');
            }
            
            if (Input::get('new') !== Input::get('new_confirmation'))
            {
                return View::make('account.index')->with('msg', 'Las contraseñas no coinciden');
            }
            
            $user->password = Hash::make(Input::get('new'));
            $user->save();
            
            return View::make('account.index')->with('msg', 'Tu contraseña ha sido cambiada');
	}
}
