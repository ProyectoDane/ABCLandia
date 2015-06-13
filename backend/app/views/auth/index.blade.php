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
            <h4>Por favor, ingresá tus datos</h4>
            <br/>
            <form role="form" method="POST" action="{{ route('auth.login') }}">
                {{ Form::String('email', 'Email') }}
                {{ Form::Secured('password', 'Contraseña') }}
                
                @if ($failed)
                <h5>Email o contraseña inválidos</h5>
                @endif
                <input type="submit" class="btn btn-primary pull-right" data-loading-text="Enviando..." value="Entrar" />
            </form>
            
            <br />
            <br />
            <hr/>
            
            <h4>¿Olvidaste la contraseña?</h4>
            <p>Haz click <a href="{{ route('auth.password') }}">aquí</a></p>
            
        </td>
        <td>&nbsp;</td>
    </tr>
</table>

@stop