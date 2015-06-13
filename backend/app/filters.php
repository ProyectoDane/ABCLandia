<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/
use Illuminate\Support\Facades\Redirect;

App::before(function($request)
{
        $allowed =  $request->segment(1) === 'artisan'  ||
                    $request->segment(1) === 'auth'     || 
                    $request->segment(1) === 'api'      ||
                    Auth::check();
        
        if (!$allowed)
        {
            if ($request->ajax())
            {
                header('HTTP/1.1 403 Forbidden', true);
                die();
            }
            else
            {
                return Redirect::route('auth.index');
            }
        }
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authorization Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is authorized to access the route.
|
*/

Route::filter('supervisor', function()
{
        return Auth::user()->tipo === Maestro::SUPERVISOR
                ? null
                : Redirect::route('index');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function($route, $request)
{
        /*
	if (Session::token() != $request->header('X-Csrf-Token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
        */
});
