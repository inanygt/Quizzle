<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play a Quiz</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Select a Quiz to Play</h1>
        @if ($quizzes->isEmpty())
            <p>No quizzes available.</p>
        @else
            <ul>
                @foreach ($quizzes as $quiz)
                    <li>
                        <a href="{{ route('quizzle.initiateQuiz', ['quiz' => $quiz->id]) }}">{{ $quiz->subject }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>

</html>
