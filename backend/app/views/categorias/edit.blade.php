@extends('categorias.form', [
    'title' => 'Categoría: {( categoria.nombre | capitalize )}'
])

@section('footer')
    <button type="button" class="btn btn-default" ng-click="$hide()">Cancelar</button>
    <button type="button" class="btn btn-primary" ng-click="update($event)" data-loading-text="Enviando...">Guardar</button>
@stop             