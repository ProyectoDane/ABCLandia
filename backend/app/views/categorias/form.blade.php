@extends('layouts.modal')

@section('body')
    <form role="form">
        {{ Form::String('nombre',       'Nombre')       }}
        {{ Form::String('descripcion',  'Descripción')  }}
    </form>
@stop