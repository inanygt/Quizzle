@extends('quizmaster')
@section('content')
    <div class="vertical-center ai-quiz-container">
        <div class="row">
            <div class="col d-flex flex-column align-items-center text-center">


                <form method="POST" action="{{ route('quizzle.rateQuiz', ['quiz' => $quiz->id]) }}" id="quiz-form">
                    @csrf
                    <h1>{{ $quiz->name }} - Results</h1>
                    <p>Your score: {{ $score }}</p>
                    <label for="rating">Rate this quiz:</label>
                    <select name="rating" id="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <button type="submit">Submit</button>
                    <hr>
                    <a href="http://localhost:8000/" class="btn btn-dark">Back to Dashboard</a>
                </form>


            </div>
        </div>
    </div>
@endsection
