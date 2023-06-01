<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>


    <div class="container">
        <div class="question">
            <p>{{ $question->question }}</p>
        </div>

        <form method="POST" action="/quiz/{{ $quiz->id }}/question/{{ $questionNumber }}" class="answer-form">
            @csrf
            @foreach(json_decode($question->choices) as $index => $choice)
                <div class="answer-option">
                    <input type="radio" id="answer_{{ $index }}" name="answer" value="{{ $index }}">
                    <label for="answer_{{ $index }}">{{ $choice }}</label>
                </div>
            @endforeach

            <button type="submit">Submit Answer</button>
        </form>
    </div>


</body>
</html>
