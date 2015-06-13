@extends('layouts.modal', [
    'title' => 'Palabras de la categoría: {( categoria.nombre )}'
])

@section('footer')
    <button type="button" class="btn btn-primary" ng-click="$hide()">Aceptar</button>
@stop

@section('body')
    <table width="100%">
        <tr ng-repeat="row in _palabras | partition:2">
            <td ng-repeat="palabra in row">
                <div class="media" style="padding-bottom: 10px;">
                    <img class="pull-left" width="100" height="100" class="media-object" clock-src="{( palabra.imagen_id == null ? '' : '{{ str_replace('letra', '\' + palabra.letra + \'', str_replace('categoria_id', '\' + categoria.id + \'', route('categorias.palabras.imagen', ['categoria_id' => 'categoria_id', 'letra' => 'letra']))) }}' )}">
                    <div class="media-body">
                        <h4 ng-if="categoria.propia" class="media-heading text-uppercase" style="cursor: pointer;" ng-click="palabra_edit(palabra)">{( palabra.letra )}</h4>
                        <h4 ng-if="!categoria.propia" class="media-heading text-uppercase">{( palabra.letra )}</h4>
                        <p class="text-capitalize">{( palabra.palabra )}</p>
                        <button class="btn btn-default btn-sm" ng-show="palabra.sonido_id" ng-click="escuchar(categoria, palabra)">Escuchar</button>
                    </div>
                </div>
            </td>
        </tr>
    </table>
@stop