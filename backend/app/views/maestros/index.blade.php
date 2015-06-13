@extends('layouts.master', [
    'title'                 => 'Maestros',
    'angular_controller'    => 'MaestrosController'
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
                <span class="navbar-brand">Maestros</span>
            </div>

            <div class="collapse navbar-collapse" id="navbar-middle-collapse">                
                <form class="form-inline navbar-form navbar-right">
                    <div class="form-group has-feedback">
                        <label class="control-label sr-only" for="query"></label>
                        <input type="text" class="form-control" ng-model="query" id="query" placeholder="Buscar" />
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                    <button class="btn btn-default" ng-click="create()">Nuevo Maestro</button>
                </form>
            </div>

        </div>
    </nav>

    <table class="table">
        <thead>
            {{ Form::tableHeader('apellido', 'Nombre') }}
            {{ Form::tableHeader('email', 'Email') }}
            {{ Form::tableHeader('tipo', 'Tipo') }}
            <th></th>
        </thead>
        <tbody>
            <tr ng-repeat="maestro in maestros | filter:query | orderBy:field:reverse">
                <td>{( maestro | nombreCompleto )}</td>
                <td>{( maestro.email )}</td>
                <td>{( maestro.tipo | tipoMaestro )}</td>
                <td class="text-right">
                    <button class="btn btn-default" ng-click="edit(maestro)">Editar</button>
                    <button class="btn btn-default" ng-click="delete(maestro)">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
@stop

@section('scripts')
<script>
    abclandiaApp
    
    .filter('tipoMaestro', function() {
        return function(input, scope) {
            return input == 1 ? 'Maestro' : 'Supervisor';
        }
    })
    
    .run(function($templateCache) {
        $templateCache.put('edit.tpl.html',     {{ $edit_tpl }});
        $templateCache.put('create.tpl.html',   {{ $create_tpl }});
        $templateCache.put('delete.tpl.html',   {{ $delete_tpl }});
        $templateCache.put('alert.tpl.html',    {{ $alert_tpl }});
    })
    
    .controller('MaestrosController', function ($scope, $flash, $filter, $http, $modal) {

        $scope.maestros = {{ $maestros }};
        $scope.field = 'apellido';
        $scope.reverse = false;

        $scope.destroy = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http.delete('{{ route('maestros.destroy', 'id') }}'.replace('id', $scope.maestro.id)).success(function(response) {
                $scope.$hide();
                btn.button('reset');
                
                if (response.status === 'success')
                {
                    $scope.maestros.splice($scope.maestros.indexOf($scope.maestro), 1);
                    $flash.show('¡Maestro eliminado con <b>éxito</b>!');
                }
                else
                {
                    $scope.cuerpo = response.msg;
                    $scope.$show('alert.tpl.html', 'center');
                }
            });
        };

        $scope.delete = function(maestro)
        {
            $scope.maestro = maestro;
            $scope.cuerpo = '¿Está seguro que quiere eliminar al maestro ' + $filter('nombreCompleto')(maestro) + '?';
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

            $http.post('{{ route('maestros.store') }}', $scope.form).success(function(response) {
                if (response.status == "success")
                {
                    $scope.maestros.push(response.data);
                    $scope.$hide();

                    $flash.show('¡Maestro creado con <b>éxito</b>!');
                }
                else
                {
                    $scope.errors = response.data;
                }
                btn.button('reset');
            });
        };

        $scope.edit = function(maestro)
        {
            $scope.$show('edit.tpl.html', 'top');
            $scope.form = angular.copy(maestro);
            $scope.errors = {};
            $scope.maestro = maestro;
        }

        $scope.update = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http.put('{{ route('maestros.update', 'id') }}'.replace('id', $scope.maestro.id), $scope.form).success(function(response) {
                if (response.status == "success")
                {
                    angular.copy(response.data, $scope.maestro);
                    $scope.$hide();

                    $flash.show('¡Maestro guardado con <b>éxito</b>!');
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