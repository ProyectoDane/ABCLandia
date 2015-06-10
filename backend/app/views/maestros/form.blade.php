@extends('layouts.modal')

@section('body')
    <form role="form">
        {{ Form::String('nombre',     'Nombre') }}
        {{ Form::String('apellido',   'Apellido') }}
        {{ Form::String('email',      'Email') }}
        
        {{ Form::Enum('tipo', 'Tipo', array(
            '1' => 'Maestro',
            '2' => 'Supervisor'
        )) }}
    </form>
@stop