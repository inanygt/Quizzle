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
        <h1>{{$quiz->name}}</h1>
        <div id="timer"></div>
        <p>Question {{ Session::get('question_number') }}</p>

        <p>{{$nextQuestion->question}}</p>

        <form id="quiz-form" method="post" action="{{route('quizzle.processAnswer')}}">
            @csrf
            <input type="hidden" name="questionId" value="{{$nextQuestion->id}}">
            <div class="answer">
                @foreach($nextQuestion->answers as $answer)
                    <label for="answer{{$answer->id}}" class="answer-block">
                        <input type="radio" class="answer-radio" id="answer{{$answer->id}}" name="answerId" value="{{$answer->id}}">
                        {{$answer->text}}
                    </label>
                @endforeach

            </div>
            <input type="radio" id="noAnswer" name="answerId" value="1" style="display:none">
        </form>
    </div>
</body>
</html>
