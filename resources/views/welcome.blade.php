@extends('layouts.app')

@section('content')
<div class="title m-b-md">
    Larattel by platzi
</div>
@if (isset($teacher))
<p>Profesor: {{ $teacher }} </p>
@else
<p>Profesor a definir</p>
@endif
<div class="links">
@foreach ($links as $link => $text)
    <a href=" {{ $link }} " target="_blank"> {{$text}} </a>
@endforeach
</div>
@endsection