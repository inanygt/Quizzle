<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <script>
    document.addEventListener("DOMContentLoaded", function() {
    var timeRemaining = 20; // 20 seconds per question
    var timerElement = document.getElementById('timer');
    var formElement = document.getElementById('quiz-form');
    var noAnswerElement = document.getElementById('noAnswer');

    function updateTimer() {
        timerElement.innerText = "Time remaining: " + timeRemaining + " seconds";

        timeRemaining--;

        if (timeRemaining < 0) {
            noAnswerElement.checked = true;
            formElement.submit();
        }
    }

    setInterval(updateTimer, 1000);
    updateTimer();

    var answerRadios = document.querySelectorAll(".answer-radio");
    answerRadios.forEach(function(radio) {
        radio.addEventListener("click", function() {
            formElement.submit();
        });
    });
});

    </script>
</head>
<body>
    <div class="container">
        <form method="POST" id="quiz-form" action="{{ route('quiz.submitAnswer', ['quiz' => $quiz->id, 'question' => $questionNumber]) }}">
            @csrf
            <h1>{{ $question->text }}</h1>
            <div id="timer"></div>
            <div class="answer">
            @foreach($question->answers as $answer)
                <label for="answer{{ $answer->id }}" class="answer-block" onclick="document.getElementById('answer{{ $answer->id }}').click();">
                    <input type="radio" id="answer{{ $answer->id }}" name="answer" value="{{ $answer->id }}" class="answer-radio">
                    {{ $answer->text }}
                </label>
            @endforeach
            </div>
            <input type="radio" id="noAnswer" name="answer" value="noAnswer" style="display:none">
            {{-- <button type="submit">Next Question</button> --}}
        </form>
    </div>


</body>
</html>
