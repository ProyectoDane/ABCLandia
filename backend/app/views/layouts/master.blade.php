<!DOCTYPE html>

<html ng-app="abclandia" ng-controller="{{ $angular_controller }}">
    <head>
        <title>ABCLandia - {{ $title }}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- build:laravelcss css/abclandia.css -->
        {{ HTML::style('css/abclandia-bootstrap.css'); }}
        
        {{ HTML::style('bower_components/angular-motion/dist/angular-motion.css'); }}
        {{ HTML::style('bower_components/jquery-ui/themes/blitzer/jquery-ui.css'); }}
        <!-- /build -->
        <style>
            body {
                padding: 50px;
                padding-top: 220px;
                padding-bottom: 22px;
            }
            #alert-container {
                position: absolute;
                bottom: 20px;
                left: 50px;
                right: 50px;
            }
            .navbar-links {
                //border-top: solid 1px #000;
                //border-bottom: solid 1px #000;
            }
            .background-white {
                background-color: #FFF;
                background-image: url('{{ asset('/img/banner_background.png') }}');
                font-size: 30px;
            }
        </style>
        
        @yield('styles')
        
        <!-- build:laraveljs js/abclandia.js -->
        {{ HTML::script('bower_components/jquery/jquery.js'); }}
        
        {{ HTML::script('bower_components/angular/angular.js'); }}
        {{ HTML::script('bower_components/angular-animate/angular-animate.js'); }}
        
        {{ HTML::script('js/angular-strap.js'); }}
        {{ HTML::script('js/angular-strap.tpl.js'); }}
        
        {{ HTML::script('bower_components/chosen/chosen.jquery.js'); }}
        {{ HTML::script('bower_components/angular-chosen-localytics/chosen.js'); }}
        
        {{ HTML::script('bower_components/bootstrap/dist/js/bootstrap.js'); }}
        
        {{ HTML::script('bower_components/datejs/build/date.js'); }}

        {{ HTML::script('bower_components/jquery-ui/ui/datepicker.js'); }}
        {{ HTML::script('bower_components/jquery-ui/ui/i18n/datepicker-es.js'); }}
        
        {{ HTML::script('js/app.js'); }}
        
        {{ HTML::script('bower_components/highcharts/highcharts.js'); }}
        {{ HTML::script('bower_components/highcharts/modules/exporting.js'); }}
        <!-- /build -->
        
        @yield('scripts')
    </head>
    
    <body>
        
        <div id="alert-container"></div>
        
        @if (Auth::check())
        <!-- TOP BAR -->
            <nav class="navbar navbar-fixed-top" role="navigation">
                <div class="container-fluid background-white">
                    <img src="{{ asset('img/logo_small.png') }}" />
                        <div class="pull-right"><br />¡Bienvenido a ABCLandia, {{ Auth::user()->nombre . " " . Auth::user()->apellido }}!</div>
                </div>
            
                <div class="container-fluid navbar-default navbar-links">

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-top-collapse">
                        
                        @if (Auth::user()->tipo === Maestro::SUPERVISOR)
                        <ul class="nav navbar-nav">
                            <li class="dropdown{{ strpos(Route::currentRouteName(), 'alumnos') === 0 ? ' active' : '' }}">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Alumnos <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('alumnos.mis') }}">Mis Alumnos</a></li>
                                    <li><a href="{{ route('alumnos.index') }}">Todos los Alumnos</a></li>
                                </ul>
                            </li>
                            <li {{ strpos(Route::currentRouteName(), 'maestros') === 0 ? 'class="active"' : '' }}><a href="{{ route('maestros.index') }}">Maestros</a></li>
                            <li {{ strpos(Route::currentRouteName(), 'categorias') === 0 ? 'class="active"' : '' }}><a href="{{ route('categorias.index') }}">Categor&iacute;as</a></li>   
                            <li {{ strpos(Route::currentRouteName(), 'reportes') === 0 ? 'class="active"' : '' }}><a href="{{ route('reportes.index') }}">Reportes</a></li>
                        </ul>
                        @else
                        <ul class="nav navbar-nav">
                            <li {{ strpos(Route::currentRouteName(), 'alumnos') === 0 ? 'class="active"' : '' }}><a href="{{ route('alumnos.mis') }}">Mis Alumnos</a></li>
                            <li {{ strpos(Route::currentRouteName(), 'categorias') === 0 ? 'class="active"' : '' }}><a href="{{ route('categorias.index') }}">Categor&iacute;as</a></li>
                            <li {{ strpos(Route::currentRouteName(), 'reportes') === 0 ? 'class="active"' : '' }}><a href="{{ route('reportes.index') }}">Reportes</a></li>
                        </ul>
                        @endif

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown{{ strpos(Route::currentRouteName(), 'micuenta') === 0 ? ' active' : '' }}">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Mi Cuenta <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li {{ strpos(Route::currentRouteName(), 'micuenta') === 0 ? 'class="active"' : '' }}><a href="{{ route('account.index') }}">Cambiar Contraseña</a></li>
                                    <li><a href="{{ route('auth.logout') }}">Salir</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
        
                </div>
            </nav>   
        <!-- TOP BAR -->
        @endif

        @yield('content')
        
        <!-- FOOTER -->
            <hr />
            ABCLandia &COPY; 2014
        <!-- FOOTER -->
    </body>
</html>