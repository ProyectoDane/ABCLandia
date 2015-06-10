@extends('layouts.master', [
    'title'                 => $title,
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
                <span class="navbar-brand">{{ $title }}</span>
            </div>

            <div class="collapse navbar-collapse" id="navbar-middle-collapse">                
                <form class="form-inline navbar-form navbar-right">
                    <div class="form-group has-feedback">
                        <label class="control-label sr-only" for="query"></label>
                        <input type="text" class="form-control" ng-model="query" id="query" placeholder="Buscar" />
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                    @if ($esSupervisor && $show_new)
                    <button class="btn btn-default" ng-click="create()">Nuevo Alumno</button>
                    @endif
                </form>
            </div>

        </div>
    </nav>

    <table class="table">
        <thead>
            {{ Form::tableHeader('apellido', 'Nombre') }}
            {{ Form::tableHeader('edad', 'Edad') }}
            {{ Form::tableHeader('sexo', 'Sexo') }}
            {{ Form::tableHeader('categoria_nombre', 'Categoría') }}
            {{ Form::tableHeader('maestros_nombres', 'Maestros') }}
            <th></th>
        </thead>
        <tbody>
            <tr ng-repeat="alumno in alumnos | filter:query | orderBy:field:reverse">
                <td>{( alumno | nombreCompleto )}</td>
                <td>{( alumno.edad )}</td>
                <td>{( alumno.sexo | sexo )}</td>
                <td>{( alumno.categoria_nombre )}</td>
                <td>{( alumno.maestros_nombres )}</td>
                <td class="text-right">
                    <button class="btn btn-default" ng-click="edit(alumno)">Editar</button>
                    @if ($esSupervisor)
                        <button class="btn btn-default" ng-click="delete(alumno)">Eliminar</button>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
@stop

@section('scripts')
<script>
    abclandiaApp

    .run(function($templateCache) {
        $templateCache.put('edit.tpl.html',     {{ $edit_tpl }});
        @if ($esSupervisor)
            $templateCache.put('create.tpl.html',   {{ $create_tpl }});
            $templateCache.put('delete.tpl.html',   {{ $delete_tpl }});
        @endif
    })

    .controller('AlumnosController', function ($scope, $flash, $filter, $http, $modal, $http_file) {
        @if ($esSupervisor)
        $scope.maestros = {{ $maestros }};
        @endif
        $scope.alumnos = {{ $alumnos }};
        $scope.categoria_id = {{ $categorias }};
        $scope.field = 'apellido';
        $scope.reverse = false;

        $scope.destroy = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http.delete('{{ route('alumnos.destroy', 'id') }}'.replace('id', $scope.alumno.id)).success(function() {
                $scope.alumnos.splice($scope.alumnos.indexOf($scope.alumno), 1);
                $scope.$hide();
                btn.button('reset');
                $flash.show('¡Alumno eliminado con <b>éxito</b>!');
            });
        };

        $scope.delete = function(alumno)
        {
            $scope.alumno = alumno;
            $scope.cuerpo = '¿Está seguro que quiere eliminar al alumno ' + $filter('nombreCompleto')(alumno) + '?';
            $scope.$show('delete.tpl.html', 'center');
        };

        $scope.create = function()
        {
            $scope.$show('create.tpl.html', 'top');
            $scope.form = {};
            $scope.errors = {};
        }

        $scope.store = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http_file.post('{{ route('alumnos.store') }}', $scope.form).success(function(response) {
                if (response.status == "success")
                {
                    $scope.alumnos.push(response.data);
                    $scope.$hide();

                    $flash.show('¡Alumno creado con <b>éxito</b>!');
                }
                else
                {
                    $scope.errors = response.data;
                }
                btn.button('reset');
            });
        };

        $scope.edit = function(alumno)
        {
            $scope.$show('edit.tpl.html', 'top');
            $scope.form = angular.copy(alumno);
            $scope.errors = {};
            $scope.alumno = alumno;
        }

        $scope.update = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http_file.put('{{ route('alumnos.update', 'id') }}'.replace('id', $scope.alumno.id), $scope.form).success(function(response) {
                if (response.status == "success")
                {
                    angular.copy(response.data, $scope.alumno);
                    $scope.$hide();

                    $flash.show('¡Alumno guardado con <b>éxito</b>!');
                }
                else
                {
                    $scope.errors = response.data;
                }
                btn.button('reset');
            });
        };
        
        $scope.$show = function(template, position)
        {
            if ($scope.$activeModal) $scope.$activeModal.self.hide();
            
            $scope.$activeModal = { next: $scope.$activeModal, self: $modal({
                container: 'body',
                animation: 'am-fade-and-scale',
                placement: position,
                template: template,
                scope: $scope
            })};
        }
        
        $scope.$hide = function() {
            if (!$scope.$activeModal) return;
            $scope.$activeModal.self.hide(!$scope.$activeModal.next);
            
            if ($scope.$activeModal.next)
            {
                $scope.$activeModal = $scope.$activeModal.next;
                $scope.$activeModal.self.show(); 
            }
            else
            {
                $scope.$activeModal = undefined;
            }
        }
    });
</script>
@stop