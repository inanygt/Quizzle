@extends('quizmaster')
@section('content')
    <div class="vertical-center ai-quiz-container">
        <div class="row">
            <div class="col ">
                <form method="POST" id="quiz-form"
                    action="{{ route('quiz.submitAnswer', ['quiz' => $quiz->id, 'question' => $questionNumber]) }}">
                    @csrf
                    <h2>{{ $question->text }}</h2>
                    <div class="answer">
                        @foreach ($question->answers as $answer)
                            <label for="answer{{ $answer->id }}" class="answer-block"
                                onclick="document.getElementById('answer{{ $answer->id }}').click();">
                                <input type="radio" id="answer{{ $answer->id }}" name="answer"
                                    value="{{ $answer->id }}" class="answer-radio">
                                {{ $answer->text }}
                            </label>
                        @endforeach
                    </div>
                    <input type="radio" id="noAnswer" name="answer" value="1" style="display:none">
                    <div id="timer"></div>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
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
@endsection
