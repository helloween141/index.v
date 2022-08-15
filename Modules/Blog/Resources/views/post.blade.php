@extends('blog::layouts.master')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>
        {!! $post->full_text !!}
    </p>
@endsection
