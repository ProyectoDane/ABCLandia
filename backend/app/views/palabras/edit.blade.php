@extends('layouts.modal', [
    'title' => 'Letra {( form.letra | capitalize )} de la categoría: {( categoria.nombre )}'
])

@section('body')
    <form role="form">
        {{ Form::String('palabra', 'Palabra') }}
        {{ Form::ImageUpload('foto', 'Foto', "{( form.imagen_id == null ? '' : '" . str_replace('letra', '\' + palabra.letra + \'', str_replace('categoria_id', '\' + categoria.id + \'', route('categorias.palabras.imagen', ['categoria_id' => 'categoria_id', 'letra' => 'letra']))) . "' )}") }}
        {{ Form::FileUpload('sonido', 'Sonido') }}
    </form>
@stop

@section('footer')
    <button type="button" class="btn btn-default" ng-click="$hide()">Cancelar</button>
    <button type="button" class="btn btn-primary" ng-click="palabra_update($event)" data-loading-text="Enviando...">Guardar</button>
@stop  