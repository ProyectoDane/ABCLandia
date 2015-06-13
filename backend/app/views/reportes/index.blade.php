@extends('layouts.master', [
    'title'                 => 'Alumnos',
    'angular_controller'    => 'AlumnosController'
])

@section('content')

    <nav class="navbar navbar-default">

        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-middle-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">Reportes</span>
            </div>
        </div>
    </nav>

    {{ Form::Enum('metrica', 'Métrica', array(
        '1' => 'Cantidad promedio de fallas',
        '2' => 'Tiempo promedio de resolución',
        '3' => 'Nivel de dificultad'
    )) }}
    
    <table width="100%">
        <tr>
            <td width="48%">
                {{ Form::String('desde', 'Desde') }}
            </td>
            <td width="4%">&nbsp;</td>
            <td width="48%">
                {{ Form::String('hasta', 'Hasta') }}
            </td>
        </tr>
        
        <tr>
            <td width="48%">
                {{ Form::Chosen('alumnos', 'Alumnos', true, "(_.apellido + ', ' + _.nombre)") }}
            </td>
            <td width="4%">&nbsp;</td>
            <td width="48%">
                {{ Form::Chosen('categoria_id', 'Categoría', false) }}
            </td>
        </tr>
        
        <tr>
            <td width="48%">
                {{ Form::Enum('ejercicio', 'Ejercicio', array(
                    '0' => 'TODOS',
                    '1' => 'Ejercicio 1',
                    '2' => 'Ejercicio 2',
                    '3' => 'Ejercicio 3',
                    '4' => 'Ejercicio 4',
                    '5' => 'Ejercicio 5',
                    '6' => 'Ejercicio 6'
                )) }}
            </td>
            <td width="4%">&nbsp;</td>
            <td width="48%">
                {{ Form::Enum('nivel', 'Nivel', array(
                    '0' => 'TODOS',
                    '1' => 'Nivel 1',
                    '2' => 'Nivel 2',
                    '3' => 'Nivel 3'
                )) }}
            </td>
        </tr>
        
        <tr>
            <td width="48%">
                @if ($esSupervisor)
                    {{ Form::Chosen('maestros', 'Maestro', false, "(_.apellido ? _.apellido + ', ' + _.nombre : _.nombre)") }}
                @endif
            </td>
            <td width="4%">&nbsp;</td>
            <td width="48%">
                &nbsp;
            </td>
        </tr>
    </table>

    <button
        type="button"
        class="btn btn-default"
        ng-click="generar_reporte()"
        ng-disabled="false">Generar Reporte</button>
    <br /> <br /> <br />
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
@stop

@section('scripts')
<script>
    abclandiaApp
    .controller('AlumnosController', function ($scope, $flash, $filter, $http, $modal, $http_file) {
        
        $("#desde").datepicker({
        dateFormat:'dd/mm/yy',
        maxDate: new Date(),
            onClose: function(selectedDate) {
                $scope.form.desde = $("#desde").val();
                $("#hasta").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#hasta").datepicker({
            dateFormat:'dd/mm/yy',
            minDate: new Date().add(-7).days(),
            onClose: function(selectedDate) {
                $scope.form.hasta = $("#hasta").val();
                $("#desde").datepicker("option", "maxDate", selectedDate);
            }
        });
        
        @if ($esSupervisor)
        $scope.maestros = {{ $maestros }};
        @endif
        $scope.alumnos = {{ $alumnos }};
        $scope.categoria_id = {{ $categorias }};
        
        $scope.form = {
            metrica: '',
            alumnos: '',
            desde: new Date().add(-7).days().toString('dd/MM/yyyy'),
            hasta: new Date().toString('dd/MM/yyyy'),
            maestros: '',
            categoria_id: '',
            ejercicio: '',
            nivel: '',
        };
        
        $scope.generar_reporte = function()
        {
            var series = [];
            var index = 0;
                
            $http.post('{{ route('api.reportes.index') }}', $scope.form).success(function(response) {
                if (response.status === 'errors')
                {
                    $scope.errors = response.data;
                    return;
                }
                $scope.errors = {};
                
                $(response).each(function(i, e) {
                    var data = [];
                    var index2 = 0;
                    $(e.data).each(function(j, l)
                    {
                        // Split timestamp into [ Y, M, D, h, m, s ]
                        var t = l.date.split(/[- :]/);

                        // Apply each element to the Date function
                        var d = Date.UTC(t[0], t[1]-1, t[2]);
                        
                        data[index2++] = [d, parseFloat(l.metrica)];
                    });
                    series[index++] = {
                        name: e.alumno_apellido + ' ' + e.alumno_nombre,
                        data : data
                    };
                });
                
                var title;
                if ($scope.form.metrica == '1') title = 'Cantidad promedio de fallas';
                if ($scope.form.metrica == '2') title = 'Tiempo promedio de resolución';
                if ($scope.form.metrica == '3') title = 'Nivel de dificultad';
        
                $('#container').highcharts({
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: 'Reportes ABCLandia'
                    },
                    subtitle: {
                        text: title
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: { // don't display the dummy year
                            month: '%e %b',
                            year: '%b'
                        },
                        title: {
                            text: 'Fecha'
                        }
                    },
                    yAxis: {
                        title: {
                            text: title
                        },
                        min: 0
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br>',
                        pointFormat: '{point.x:%e %b}: {point.y}'
                    },
                    series: series
                });
            });
        }
    });
</script>
@stop