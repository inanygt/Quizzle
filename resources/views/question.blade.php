<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <form method="POST" action="{{ route('quiz.submitAnswer', ['quiz' => $quiz->id, 'questionNumber' => $questionNumber]) }}">
        @csrf
        <h1>{{ $question->text }}</h1>
        @foreach($question->answers as $answer)
            <div class="answer">
                <input type="radio" id="answer{{ $answer->id }}" name="answer" value="{{ $answer->id }}">
                <label for="answer{{ $answer->id }}">{{ $answer->text }}</label>
            </div>
        @endforeach
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <button type="submit">Next Question</button>
    </form>

</div>
</body>
</html>
