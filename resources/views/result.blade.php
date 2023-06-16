@extends('quizmaster')
@section('content')
    <div class="container">
        <h1>Quiz Results</h1>
        <h2>Your Score: {{ $score }}/{{ $quiz->num_questions }}</h2>
        <p>Thanks for participating in the quiz! You scored {{ $score }} out of {{ $quiz->num_questions }}.</p>

        <a href="/quiz/start" class="btn">Start New Quiz</a>
    </div>
@endsection
