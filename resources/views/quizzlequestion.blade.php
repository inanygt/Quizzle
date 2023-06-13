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
        <h1>{{ $quiz->subject }}</h1>

        <div class="question">
            <h2>{{ $currentQuestion->question }}</h2>

            <form action="{{ route('quizzle.provideAnswer', ['quiz' => $quiz->id, 'questionNumber' => $currentQuestion->id]) }}" method="POST">
                @csrf
                @foreach($currentQuestion->answers as $answer)
                    <div class="answer">
                        <input type="radio" id="answer{{ $answer->id }}" name="answer" value="{{ $answer->id }}">
                        <label for="answer{{ $answer->id }}">{{ $answer->answer }}</label>
                    </div>
                @endforeach

                <button type="submit">Submit</button>
            </form>

        </div>
    </div>
</body>
</html>
