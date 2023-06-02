@extends('masters')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="pt-5">Discover our collection of Quizzles!</h1>
                    {{-- Cards --}}
                    <div class="row">
                        @foreach ($categories as $category)
                        <div class="col-md-6">
                            <div class="card mt-3">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h1 class="card-title">{{ $category->name }}</h1>
                                    <p class="card-text"> {{$category->description}} </p>
                                    <a href="{{ route($category->name) }}" class="btn btn-primary">Explore here</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>


@endsection
