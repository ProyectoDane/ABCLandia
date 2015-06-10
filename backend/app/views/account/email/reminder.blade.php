{{ $nombre }}, se ha solicitado recuperar el password de tu cuenta en ABCLandia.<br />
Para continuar con la solicitud seguí el siguiente <a href="{{ route('auth.recover', ['id' => $id, 'token' => $token]) }}">enlace</a><br />
Si no haz sido tu ignora este email.<br />
<br />
Equipo de ABCLandia