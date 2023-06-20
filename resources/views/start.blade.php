@extends('quizmaster')
@section('content')
    <div class="vertical-center ai-quiz-container">
        <div class="d-flex flex-column align-items-center text-center"></div>
        {{-- Form --}}
        <form method="POST" action="/quiz/start">
            @csrf
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject">
            <label for="num_questions">Number of Questions:</label>
            <input type="number" id="num_questions" name="num_questions">
            <div class="d-flex justify-content-center">
                <button class="btn btn-dark" type="submit">Start Quiz</button>
            </div>
        </form>
    </div>
    </div>
@endsection
