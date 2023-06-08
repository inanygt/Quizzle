<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var timeRemaining = 15; // 15 seconds per question
        var timerElement = document.getElementById('timer');
        var formElement = document.getElementById('quiz-form');
        var timeRemainingElement = document.getElementById('time_remaining');

        function updateTimer() {
            timerElement.innerText = "Time remaining: " + timeRemaining + " seconds";
            timeRemainingElement.value = timeRemaining;

            timeRemaining--;

            if (timeRemaining < 0) {
                formElement.submit();
            }
        }

        setInterval(updateTimer, 1000);
        updateTimer();
    });
    </script>

</head>
<body>
<div class="container">
    <form method="POST" id="quiz-form" action="{{ route('quiz.submitAnswer', ['quiz' => $quiz->id, 'question' => $questionNumber]) }}">
        @csrf
        <h1>{{ $question->text }}</h1>
        <div id="timer"></div>
        @foreach($question->answers as $answer)
            <div class="answer">
                <input type="radio" id="answer{{ $answer->id }}" name="answer" value="{{ $answer->id }}">
                <label for="answer{{ $answer->id }}">{{ $answer->text }}</label>
            </div>
        @endforeach
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <input type="hidden" id="time_remaining" name="time_remaining">
        <button type="submit">Next Question</button>
    </form>
</div>
</body>
</html>
