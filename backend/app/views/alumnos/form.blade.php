@extends('layouts.modal')

@section('body')
    <form role="form">
        {{ Form::String('nombre',   'Nombre') }}
        {{ Form::String('apellido', 'Apellido') }}
        {{ Form::String('edad',     'Edad') }}
        
        {{ Form::Enum('sexo', 'Sexo', array(
            '1' => 'Femenino',
            '2' => 'Masculino'
        )) }}
        
        @if ($esSupervisor)
            {{ Form::Chosen('maestros', 'Maestros', true, "(_.apellido + ', ' + _.nombre)") }}
        @endif
        
        {{ Form::Chosen('categoria_id', 'Categoría', false) }}
        {{ Form::Enum('tipo_letra', 'Tipo de Letras', array(
            '1' => 'Mayúscula',
            '2' => 'Minúscula',
            '3' => 'Mayúscula y Minúscula'
        )) }}
    </form>
@stop