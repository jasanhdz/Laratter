@extends('layouts.app')

@section('content')
   <h1>{{$user->name}}</h1><br> 
   @if ($method == 'followers')
   <h3>Seguidores:</h3>
   @elseif($method == 'follows')
   <h3>Seguidos:</h3>
   @endif
  <ul>
  @foreach ($follows as $follow)
    <li>{{ $follow->username }}</li>   
  @endforeach
  </ul>
@endsection