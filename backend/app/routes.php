<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => 'api'], function()
{
    Route::get('/maestros', ['as' => 'api.maestros.index', 'uses' => 'Api\MaestrosController@index']);
    Route::get('/maestros/{id}/alumnos', ['as' => 'api.maestros.alumnos', 'uses' => 'Api\MaestrosController@alumnos']);
    
    Route::post('estadisticas', ['as' => 'api.estadisticas.feed', 'uses' => 'Api\EstadisticasController@feed']);
    Route::get('estadisticas', ['as' => 'api.estadisticas.show', 'uses' => 'Api\EstadisticasController@show']);
    
    Route::get('/alumnos/{id}', ['as' => 'api.alumnos.index', 'uses' => 'Api\AlumnosController@index']);  
    
    Route::get('/imagenes/{id}', ['as' => 'api.imagenes.show', 'uses' => 'Api\ImagenesController@show']);
    Route::get('/sonidos/{id}', ['as' => 'api.sonidos.show', 'uses' => 'Api\SonidosController@show']);
    
    Route::post('reportes', ['as' => 'api.reportes.index', 'uses' => 'Api\ReportesController@index']);
    Route::get('reportes', ['as' => 'api.reportes.index', 'uses' => 'Api\ReportesController@index']);
});

Route::group(['prefix' => 'auth'], function()
{
    Route::get('/login', ['as' => 'auth.index', 'uses' => 'AuthController@index']);
    Route::post('/login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
    
    Route::get('/password', ['as' => 'auth.password', 'uses' => 'AuthController@password']);
    Route::post('/password', ['as' => 'auth.password.check', 'uses' => 'AuthController@passwordCheck']);
    
    Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);
    
    Route::get('/recover/{id}/{token}', ['as' => 'auth.recover', 'uses' => 'AuthController@recover']);
});

Route::get('/', ['as' => 'index', function()
{
    return Illuminate\Support\Facades\Redirect::route('alumnos.mis');
}]);

Route::group(['prefix' => 'categorias'], function()
{
    Route::post('/{id}/copy', ['as' => 'categorias.copy', 'uses' => 'CategoriasController@copy']);
    
    Route::get('/{categoria_id}/palabras', ['as' => 'categorias.palabras.index', 'uses' => 'PalabrasController@index']);
    Route::put('/{categoria_id}/palabras/{letra}', ['as' => 'categorias.palabras.update', 'uses' => 'PalabrasController@update']);
    Route::get('/{categoria_id}/palabras/{letra}/imagen', ['as' => 'categorias.palabras.imagen', 'uses' => 'PalabrasController@imagen']);
    Route::get('/{categoria_id}/palabras/{letra}/sonido', ['as' => 'categorias.palabras.sonido', 'uses' => 'PalabrasController@sonido']);
});

Route::group(['prefix' => 'maestros', 'before' => 'supervisor'], function()
{
    Route::get      ('/',           ['uses' => 'MaestrosController@index',      'as' => 'maestros.index']);
    Route::get      ('/create',     ['uses' => 'MaestrosController@create',     'as' => 'maestros.create']);
    Route::post     ('/',           ['uses' => 'MaestrosController@store',      'as' => 'maestros.store']);
    Route::get      ('/{id}',       ['uses' => 'MaestrosController@show',       'as' => 'maestros.show']);
    Route::get      ('/{id}/edit',  ['uses' => 'MaestrosController@edit',       'as' => 'maestros.edit']);
    Route::put      ('/{id}',       ['uses' => 'MaestrosController@update',     'as' => 'maestros.update']);
    Route::delete   ('/{id}',       ['uses' => 'MaestrosController@destroy',    'as' => 'maestros.destroy']);
});

Route::group(['prefix' => 'alumnos'], function()
{
    Route::get      ('/',           ['uses' => 'AlumnosController@index',      'as' => 'alumnos.index',     'before' => 'supervisor']);
    Route::get      ('/create',     ['uses' => 'AlumnosController@create',     'as' => 'alumnos.create',    'before' => 'supervisor']);
    Route::post     ('/',           ['uses' => 'AlumnosController@store',      'as' => 'alumnos.store',     'before' => 'supervisor']);
    Route::get      ('/{id}',       ['uses' => 'AlumnosController@show',       'as' => 'alumnos.show']);
    Route::get      ('/{id}/edit',  ['uses' => 'AlumnosController@edit',       'as' => 'alumnos.edit']);
    Route::put      ('/{id}',       ['uses' => 'AlumnosController@update',     'as' => 'alumnos.update']);
    Route::delete   ('/{id}',       ['uses' => 'AlumnosController@destroy',    'as' => 'alumnos.destroy',   'before' => 'supervisor']);
});

Route::resource('categorias', 'CategoriasController');

Route::get('/misalumnos', ['as' => 'alumnos.mis', 'uses' => 'AlumnosController@mios']);

Route::get('/micuenta', ['as' => 'account.index', 'uses' => 'AccountController@index']);
Route::post('/micuenta', ['as' => 'account.password', 'uses' => 'AccountController@password']);

Route::resource('reportes', 'ReportesController');

/*
|--------------------------------------------------------------------------
| Form Macros
|--------------------------------------------------------------------------
*/

Form::macro('tableHeader', function($field, $label)
{
    return <<<TH
        <th>
            <span style="cursor: pointer;" ng-click="reverse = field == '$field' ? !reverse : false; field = '$field';">
                $label
            </span>
            <span ng-if="field == '$field'" ng-class="{'glyphicon-chevron-down':!reverse, 'glyphicon-chevron-up':reverse}" class="glyphicon"></span>
        </th>
TH;
});

Form::macro('String', function($field, $label)
{
    return <<<INPUT
        <div class="form-group" ng-class="{'has-error': errors.$field}">
            <label class="control-label" for="$field">$label</label>
            
            <input ng-model="form.$field" type="text" class="form-control" id="$field" name="$field">
            
            <span class="help-block" ng-bind="errors.$field"></span>
        </div>
INPUT;
});

Form::macro('Secured', function($field, $label)
{
    return <<<INPUT
        <div class="form-group" ng-class="{'has-error': errors.$field}">
            <label class="control-label" for="$field">$label</label>
            
            <input ng-model="form.$field" type="password" class="form-control" id="$field" name="$field">
            
            <span class="help-block" ng-bind="errors.$field"></span>
        </div>
INPUT;
});

Form::macro('Enum', function($field, $label, $options)
{
    $input = <<<INPUT
        <div class="form-group" ng-class="{'has-error': errors.$field}">
            <label class="control-label" for="$field">$label</label>
            
            <select ng-model="form.$field" class="form-control" id="$field">
                <option value="">Seleccione...</option>
INPUT;
    
    foreach($options as $value => $option)
    {
        $input .= <<<OPTION
            <option value="$value">$option</option>
OPTION;
    }
                    
    $input .= <<<INPUT
            </select>
 
            <span class="help-block" ng-bind="errors.$field"></span>
        </div>
INPUT;
    
    return $input;
});

Form::macro('Chosen', function($field, $label, $multiple = true, $show = "_.nombre")
{
    $input = <<<INPUT
        <div class="form-group" ng-class="{'has-error': errors.$field}">
            <label class="control-label" for="$field">$label</label>
            
            <select
                data-placeholder="Seleccione..."
                no-results-text="'Sin resultados para'"
INPUT;
    
    if ($multiple) $input .= " multiple=\"multiple\"";
    
    $input .= <<<INPUT
                chosen="chosen"
                ng-options="_.id as $show for _ in $field"
                ng-model="form.$field"
                class="form-control"
                id="$field">
                <option value=""></option>
            </select>
 
            <span class="help-block" ng-bind="errors.$field"></span>
        </div>
INPUT;
    
    return $input;
});

Form::macro('ImageUpload', function($field, $label, $src)
{
    $input = <<<INPUT
        <div class="form-group" ng-class="{'has-error': errors.$field}">
            <label class="control-label" for="$field">$label</label>
            <br />
            <img style="width: 150px !important; height: 150px !important;" class="img-thumbnail" id="$field-image" clock-src="$src" />
            <input style="display: none;" file-model="form.$field" type="file" id="$field">
            
            <span class="help-block" ng-bind="errors.$field"></span>
        </div>
            
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#$field-image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#$field").change(function(){
                readURL(this);
            });
            
            $('#$field-image').click(function() { $("#$field").click(); });
        </script>
INPUT;
    
    return $input;
});

Form::macro('FileUpload', function($field, $label)
{
    $input = <<<INPUT
        <div class="form-group" ng-class="{'has-error': errors.$field}">
            <label class="control-label" for="$field">$label</label>
            <br />
            <input type="button" class="btn btn-default" id="$field-btn" value="Examinar..." />
            <input style="display: none;" file-model="form.$field" type="file" id="$field">
            
            <span class="help-block" ng-bind="errors.$field"></span>
        </div>
            
        <script>
            $("#$field").change(function(){
                $('#$field-btn').val($("#$field").val());
            });
            
            $('#$field-btn').click(function() { $("#$field").click(); });
        </script>
INPUT;
    
    return $input;
});

/*
|--------------------------------------------------------------------------
| Validator Extensions
|--------------------------------------------------------------------------
*/

Validator::extend('format', function($attribute, $value, $parameters)
{
    $format = $value->getClientMimeType();
    return in_array($format, $parameters);
});

Validator::extend('letra', function($attribute, $value, $parameters)
{
    $minuscula = mb_strtolower($value,'UTF-8');
    return strpos($minuscula, $parameters[0]) === 0;
});

Validator::extend('minCount', function($attribute, $value, $parameters)
{
    $size = $parameters[0];
    return count($value) >= $size;
});

Validator::extend('completa', function($attribute, $value, $parameters)
{
    $palabras_incompletas = DB::table('palabras')
            ->select(DB::raw('count(*) as count'))
            ->where('categoria_id', '=', $value)
            ->where(function($query)
            {
                $query
                ->whereRaw('imagen_id IS NULL OR sonido_id IS NULL')
                ->orWhere('palabra', '=', '');
            })
            ->get();
            
    return $palabras_incompletas[0]->count == 0;
});

Validator::extend('fecha', function($attribute, $value, $parameters)
{
    $match = preg_match('$(\d{2})/(\d{2})/(\d{4})$', $value, $matches);
    return $match && checkdate($matches[2], $matches[1], $matches[3]);
});