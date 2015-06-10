@extends('layouts.master', [
    'title'                 => 'Categorías',
    'angular_controller'    => 'CategoriasController'
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
                <span class="navbar-brand">Categorías</span>
            </div>

            <div class="collapse navbar-collapse" id="navbar-middle-collapse">                
                <form class="form-inline navbar-form navbar-right">
                    <div class="form-group has-feedback">
                        <label class="control-label sr-only" for="query"></label>
                        <input type="text" class="form-control" ng-model="query" id="query" placeholder="Buscar" />
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                    <button class="btn btn-default" ng-click="create()">Nueva Categoría</button>
                </form>
            </div>

        </div>
    </nav>

    <table class="table">
        <thead>
            {{ Form::tableHeader('nombre', 'Nombre') }}
            {{ Form::tableHeader('descripcion', 'Descripción') }}
            <th></th>
        </thead>
        <tbody>
            <tr ng-repeat="categoria in categorias | filter:query | orderBy:field:reverse">
                <td>{( categoria.nombre | capitalize )}</td>
                <td>{( categoria.descripcion )}</td>
                <td class="text-right">
                    <button class="btn btn-default" ng-click="palabras(categoria, $event)" data-loading-text="Cargando...">Palabras</button>
                    <button class="btn btn-default" ng-click="copy(categoria, $event)" data-loading-text="Enviando...">Duplicar</button>
                    <button ng-if="categoria.propia" class="btn btn-default" ng-click="edit(categoria)">Editar</button>
                    <button ng-if="categoria.propia" class="btn btn-default" ng-click="delete(categoria)">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
@stop

@section('scripts')
<script>
    abclandiaApp
    
    .filter('partition', function() {
        var cache = {};
        var filter = function(arr, size) {
            if (!arr) { return; }
            var newArr = [];
            for (var i=0; i<arr.length; i+=size) {
                newArr.push(arr.slice(i, i+size));
            }
            var arrString = JSON.stringify(arr);
            var fromCache = cache[arrString+size];
            if (JSON.stringify(fromCache) === JSON.stringify(newArr)) {
                return fromCache;
            }
            cache[arrString+size] = newArr;
            return newArr;
        };
        return filter;
    })
    
    .run(function($templateCache) {
        $templateCache.put('edit.tpl.html',     {{ $edit_tpl }});
        $templateCache.put('create.tpl.html',   {{ $create_tpl }});
        $templateCache.put('delete.tpl.html',   {{ $delete_tpl }});
        $templateCache.put('alert.tpl.html',    {{ $alert_tpl }});
        $templateCache.put('palabras.tpl.html', {{ $palabras_tpl }});
        $templateCache.put('palabras.edit.tpl.html', {{ $palabras_edit_tpl }});
    })
    
    .controller('CategoriasController', function ($scope, $flash, $filter, $http, $modal, $http_file) {

        $scope.categorias = {{ $categorias }};
        $scope.field = 'nombre';
        $scope.reverse = false;

        $scope.destroy = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http.delete('{{ route('categorias.destroy', 'id') }}'.replace('id', $scope.categoria.id)).success(function(response) {
                $scope.$hide();
                btn.button('reset');
                
                if (response.status === 'success')
                {
                    $scope.categorias.splice($scope.categorias.indexOf($scope.categoria), 1);
                    $flash.show('¡Categoría eliminada con <b>éxito</b>!');
                }
                else
                {
                    $scope.cuerpo = response.msg;
                    $scope.$show('alert.tpl.html', 'center');
                }
            });
        };

        $scope.delete = function(categoria)
        {
            $scope.categoria = categoria;
            $scope.cuerpo = '¿Está seguro que quiere eliminar la categoría ' + $filter('capitalize')(categoria.nombre) + '?';
            $scope.$show('delete.tpl.html', 'center');
        };

        $scope.create = function()
        {
            $scope.form = {};
            $scope.errors = {};
            
            $scope.$show('create.tpl.html', 'top');
        }

        $scope.store = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http.post('{{ route('categorias.store') }}', $scope.form).success(function(response) {
                if (response.status == "success")
                {
                    $scope.categorias.push(response.data);
                    $flash.show('¡Categoría creada con <b>éxito</b>!');
                    
                    $scope.palabras(response.data, $event);
                }
                else
                {
                    $scope.errors = response.data;
                    btn.button('reset');
                }
            });
        };

        $scope.edit = function(categoria)
        {
            $scope.form = angular.copy(categoria);
            $scope.errors = {};
            $scope.categoria = categoria;
            $scope.$show('edit.tpl.html', 'top');
        }

        $scope.update = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http.put('{{ route('categorias.update', 'id') }}'.replace('id', $scope.categoria.id), $scope.form).success(function(response) {
                if (response.status == "success")
                {
                    angular.copy(response.data, $scope.categoria);
                    $scope.$hide();

                    $flash.show('¡Categoría guardada con <b>éxito</b>!');
                }
                else
                {
                    $scope.errors = response.data;
                }
                btn.button('reset');
            });
        };
        
        $scope.copy = function(categoria, $event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http.post('{{ route('categorias.copy', 'id') }}'.replace('id', categoria.id)).success(function(response) {
                if (response.status == "success")
                {
                    $scope.categorias.push(response.data);
                    $flash.show('¡Categoría duplicada con <b>éxito</b>!');
                }
                else
                {
                    $scope.errors = response.data;
                }
                btn.button('reset');
            });
        };
        
        $scope.palabras = function(categoria, $event)
        {
            $scope.categoria = categoria;
            
            var btn = $($event.target);
            btn.button('loading');

            $http.get('{{ route('categorias.palabras.index', 'id') }}'.replace('id', categoria.id)).success(function(response) {
                if (response.status == "success")
                {
                    $scope._palabras = response.data;
                    $scope.$hide();
                    $scope.$show('palabras.tpl.html', 'top');
                }
                btn.button('reset');
            });
        }
        
        $scope.palabra_edit = function(palabra)
        {
            $scope.palabra = palabra;
            $scope.form = angular.copy(palabra);
            $scope.errors = {};
            
            $scope.$show('palabras.edit.tpl.html', 'top');
        }
        
        $scope.palabra_update = function($event)
        {
            var btn = $($event.target);
            btn.button('loading');

            $http_file.put('{{ route('categorias.palabras.update', ['categoria_id' => 'categoria_id', 'letra' => 'letra']) }}'.replace('categoria_id', $scope.categoria.id).replace('letra', $scope.form.letra), $scope.form).success(function(response) {
                if (response.status == "success")
                {
                    angular.copy(response.data, $scope.palabra);
                    $scope.$hide();
                    $flash.show('¡Palabra guardada con <b>éxito</b>!');
                }
                else
                {
                    $scope.errors = response.data;
                }
                btn.button('reset');
            });
        }
        
        $scope.escuchar = function(categoria, palabra)
        {
            var path = '{{ str_replace('letra', '\' + palabra.letra + \'', str_replace('categoria_id', '\' + categoria.id + \'', route('categorias.palabras.sonido', ['categoria_id' => 'categoria_id', 'letra' => 'letra']))) }}';
            path += '?time='+ $filter('date')(new Date(), 'medium');
            $('<audio src="' + path + '" autoplay></audio>').appendTo("body");
        }
        
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