@extends('masters')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="pt-5">Discover our collection of Quizzles!</h1>
                    {{-- Cards --}}
                    <div class="row">
                        {{-- Random --}}
                         <div class="col-md-6">
                            <div class="card mt-3">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h1 class="card-title">Random</h1>
                                    <p class="card-text"> "Unlock the realm of random trivia and let the unexpected test your knowledge prowess!"</p>
                                    <a href="#" class="btn btn-primary">Explore here</a>
                                </div>
                            </div>
                        </div>
                        {{-- Random --}}
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
