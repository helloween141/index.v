<h1>{{env('APP_NAME')}}. Восстановление пароля</h1>

<p>Вы можете восстановить пароль по ссылке ниже:</p>

<a href="{{ route('reset.show', '') }}/{{$token}}">восстановить пароль</a>