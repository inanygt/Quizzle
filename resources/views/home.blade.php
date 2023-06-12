@extends('masters')
@section('content')
    <div class="container">
        @include('homepage')
            {{-- Cards --}}
                    {{-- Most played Quizzles --}}
                    <div class="row">
                        <h3 class="mt-3">Most played quizzles!</h3>
                        @foreach ($pQuizzes as $pQuiz)
                        <div class="col-6">
                            <div class="card mt-3">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h4 class="card-title">{{ $pQuiz->name }}</h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="{{ url('/geography', ['id' => $pQuiz->id]) }}" class="btn btn-primary">Play!</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{-- Best raded Quizzles --}}
                    <div class="row">
                        <h3 class="mt-3">Best rated Quizzles!</h3>
                        @foreach ($rQuizzes as $rQuiz)
                        <div class="col-6">
                            <div class="card mt-3">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h4 class="card-title">{{ $rQuiz->name }}</h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="{{ url('/geography', ['id' => $rQuiz->id]) }}" class="btn btn-primary">Play!</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
    </div>
@endsection
