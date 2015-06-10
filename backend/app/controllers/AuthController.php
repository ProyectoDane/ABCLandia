<?php

class AuthController extends \BaseController {

        private $mailer;
        
        public function __construct(IMailer $mailer)
        {
            $this->mailer = $mailer;
        }
        
	public function index()
	{
            return View::make('auth.index')->with('failed', false);
	}

	public function login()
	{
            return Auth::attempt(Input::all())
                ? Redirect::intended()
                : View::make('auth.index')->with('failed', true);
	}
        
        public function logout()
        {
            Auth::logout();
            return View::make('auth.index')->with('failed', false);
        }
        
        public function password()
	{
            return View::make('auth.password')->with('msg', '');
	}
        
        public function passwordCheck()
	{
            $maestro = Maestro::where('email' , '=', Input::get('email'))->first();
            
            if ($maestro === null)
            {
                return View::make('auth.password')->with('msg', 'Email inválido');
            }
            
            $maestro->token = str_random(30);
            $maestro->save();
            
            $this->mailer->send($maestro->email, 'Recuperación de password', 'account.email.reminder', ['id' => $maestro->id, 'nombre' => $maestro->nombre, 'token' => $maestro->token]);
            
            return View::make('auth.password')->with('msg', 'Hemos envíado un email a tu cuenta con instrucciones');
	}
        
        public function recover($id, $token)
	{
            $maestro = Maestro::find($id);
            
            if ($maestro === null)
            {
                return View::make('auth.recover')->with('msg', 'Enlace inválido');
            }
            
            if ($maestro->token == null || $maestro->token !== $token)
            {
                $maestro->token = null;
                $maestro->save();
                
                return View::make('auth.recover')->with('msg', 'Enlace inválido');
            }
            
            $password = str_random(10);
            
            $maestro->token = null;
            $maestro->password = Hash::make($password);
            $maestro->save();
                    
            $this->mailer->send($maestro->email, 'Bienvenido a ABCLandia', 'account.email.welcome', ['nombre' => $maestro->nombre, 'password' => $password]);
            
            return View::make('auth.recover')->with('msg', 'Hemos envíado un email a tu cuenta con tu nueva contraseña');
	}
}
