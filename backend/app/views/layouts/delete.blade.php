@extends('layouts.modal')

@section('body')
    {( cuerpo )}
@stop

@section('footer')
    <button type="button" class="btn btn-default" ng-click="$hide()">Cancelar</button>
    <button type="button" class="btn btn-danger" ng-click="destroy($event)" data-loading-text="Enviando...">Eliminar</button>
@stop