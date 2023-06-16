@extends('masters')
@section('content')
    <div class="container-fluid">
        @include('homepage')
            {{-- Cards --}}
                    {{-- Most played Quizzles --}}
                    <div class="row">
                        <h2 class="mt-3">Most played quizzles!</h2>
                        @foreach ($pQuizzes as $pQuiz)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card mt-3">

                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h4 class="card-title">{{ $pQuiz->name }}</h4>
                                    <p class="card-text">Questions: {{$pQuiz->num_questions}}</p>
                                    {{-- Rating --}}
                                    <div class="rating">
                                    @if ($pQuiz->rating == 0)
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($pQuiz->rating == 1)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($pQuiz->rating == 2)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($pQuiz->rating == 3)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($pQuiz->rating == 4)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($pQuiz->rating == 5)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>

                                        @endif
                                        </div>
                                        <div class="mt-2">
                                    <a href="{{ route('quizzle.initiateQuiz', ['quiz' => $pQuiz->id]) }}" class="btn btn-dark">Play!</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- MIDDLEPAGE --}}
                    @include('middlepage')


                    {{-- Best rated Quizzles --}}
                    <div class="row mt-5">
                        <h2 class="mt-3">Best rated Quizzles!</h2>
                    {{-- Best rated Quizzles --}}
                    <div class="row">
                        <h3 class="mt-3">Best rated Quizzles!</h3>
                        @foreach ($rQuizzes as $rQuiz)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $rQuiz->name }}</h4>
                                    <p class="card-text">Questions: {{$pQuiz->num_questions}}</p>
                                    {{-- Rating --}}
                                    <div class="rating">
                                    @if ($rQuiz->rating == 0)
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($rQuiz->rating == 1)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($rQuiz->rating == 2)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($rQuiz->rating == 3)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($rQuiz->rating == 4)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif ($rQuiz->rating == 5)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>

                                        @endif
                                        </div>
                                        <div class="mt-2">
                                    <a href="{{ route('quizzle.initiateQuiz', ['quiz' => $pQuiz->id]) }}" class="btn btn-dark">Play!</a>

                                        </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
    </div>
@endsection
