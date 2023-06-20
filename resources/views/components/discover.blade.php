@extends('masters')

@section('content')
<div class="container">
    <h1 class="pt-5">Discover our collection of Quizzles!</h1>
    @foreach ($categories as $category)
    <div class="row">
        <h2 class="mt-3">{{ $category->name }}</h2>
        @foreach ($category->quizzes as $quiz)
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">{{ $quiz->name }}</h4>
                    <p class="card-text">Questions: {{ count($quiz->questions) }}</p>
                    {{-- Rating --}}
                    <div class="rating">
                        @if ($quiz->rating == 0)
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        @elseif ($quiz->rating == 1)
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        @elseif ($quiz->rating == 2)
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        @elseif ($quiz->rating == 3)
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        @elseif ($quiz->rating == 4)
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        @elseif ($quiz->rating == 5)
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        @endif
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('quizzle.initiateQuiz', ['quiz' => $quiz->id]) }}"
                            class="btn btn-dark">Play!</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
@endsection
