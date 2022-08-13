<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
    @vite
</head>
<body>
<h1>{{env('APP_NAME')}}</h1>
<ul>
    @forelse ($posts as $post)
        <li>
            {{ $post->title }}
        </li>
    @empty
        <p>Новости не найдены!</p>
    @endforelse
</ul>
</body>
</html>
