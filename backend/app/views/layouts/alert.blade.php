@extends('layouts.modal')

@section('body')
    {( cuerpo )}
@stop

@section('footer')
    <button type="button" class="btn btn-danger" ng-click="$hide()">Aceptar</button>
@stop