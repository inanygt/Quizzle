@extends('masters')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                 <h1>"Welcome to the ultimate fuzzle adventure! </h1>
            </div>
        </div>
          {{-- Cards --}}
                    <div class="row">
                        <h3 class="mt-3">Most played quizzles!</h3>
                        @foreach ($quizzes as $quiz)
                        <div class="col-md-2">
                            <div class="card mt-3">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h4 class="card-title">{{ $quiz->name }}</h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="{{ url('/geography', ['id' => $quiz->id]) }}" class="btn btn-primary">Play!</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
         <div class="row">
            <div class="col">
                <h3>Best rated quizzles</h3>
            </div>
        </div>
    </div>
@endsection
