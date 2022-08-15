@extends('blog::layouts.master')

@section('content')
    <ul>
        @forelse ($posts as $post)
            <li>
                <a href="{{ route('blog.post', [$post->url]) }}">{{ $post->title }}</a>
            </li>
        @empty
            <p>Новости не найдены!</p>
        @endforelse
    </ul>
@endsection
