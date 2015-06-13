@extends('maestros.form', [
    'title' => 'Nuevo Maestro'
])

@section('footer')
    <button type="button" class="btn btn-default" ng-click="$hide()">Cancelar</button>
    <button type="button" class="btn btn-primary" ng-click="store($event)" data-loading-text="Enviando...">Aceptar</button>
@stop