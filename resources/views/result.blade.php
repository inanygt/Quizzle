@extends('quizmaster')
@section('content')
    <div class="vertical-center ai-quiz-container">
        <div class="row">
            <div class="col d-flex flex-column align-items-center text-center">
            {{-- <h1>Quiz Results</h1> --}}
            <h2>Your Score: {{ $score }}/{{ $quiz->num_questions }}</h2>
            <p>Thanks for participating in the quiz! You scored {{ $score }} out of {{ $quiz->num_questions }}.</p>

            <a href="/quiz/start" class="btn btn-dark">Start New Quiz</a>
            </div>
        </div>
    </div>
@endsection
