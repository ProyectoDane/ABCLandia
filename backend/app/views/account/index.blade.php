@extends('layouts.master', [
    'title'                 => 'Cambiar Contraseña',
    'angular_controller'    => 'PasswordController'
])

@section('content')

<table width="100%">
    <tr>
        <td>&nbsp;</td>
        <td width="300">
            <h4>Por favor, ingresa tus datos</h4>
            <br/>
            <form role="form" method="POST" action="{{ route('account.password') }}">
                {{ Form::Secured('current', 'Contraseña Actual') }}
                {{ Form::Secured('new', 'Nueva Contraseña') }}
                {{ Form::Secured('new_confirmation', 'Repetir Nueva Contraseña') }}
                <h5>{{ $msg }}</h5>
                <input type="submit" class="btn btn-primary pull-right" data-loading-text="Enviando..." value="Aceptar" />
            </form>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>

@stop

@section('scripts')
<script>
    abclandiaApp.controller('PasswordController', function () {});
</script>
@stop