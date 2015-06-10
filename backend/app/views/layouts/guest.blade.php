<!DOCTYPE html>

<html>
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
                padding-top: 50px;
                padding-bottom: 22px;
            }
            #alert-container {
                position: absolute;
                bottom: 20px;
                left: 50px;
                right: 50px;
            }
            .background-white {
                background-color: #FFF;
                background-image: url({{ asset('/img/banner_background.png') }});
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
        
        <center>
            <img src="{{ asset('img/logo_big.png') }}" />
        </center>
    
        @yield('content')
        
        <!-- FOOTER -->
            <hr />
            ABCLandia &COPY; 2014
        <!-- FOOTER -->
    </body>
</html>