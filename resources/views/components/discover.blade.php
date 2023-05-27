@extends('welcome')
@section('content')
<h1>Discover</h1>

@foreach ($categories as $category)
    <p>{{$category->name}}</p>

@endforeach
@endsection
