@extends('layouts.guest', [
    'title' => 'Bienvenido'
])

@section('content')

<center><h2>¡ Bienvenido a ABCLandia !</h2></center>
<br />
<table width="100%">
    <tr>
        <td>&nbsp;</td>
        <td width="300">
            <h4>Por favor, ingresa tus datos</h4>
            <br/>
            <form role="form" method="POST" action="{{ route('auth.password.check') }}">
                {{ Form::String('email', 'Email') }}
                
                @if ($msg)
                    <h5>{{ $msg }}</h5>
                @endif
                <input type="submit" class="btn btn-primary pull-right" data-loading-text="Enviando..." value="Aceptar" />
            </form>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>

@stop