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
        <h1>Quiz Results</h1>
        <h2>Your Score: {{ $score }}/{{ $quiz->num_questions }}</h2>
        <p>Thanks for participating in the quiz! You scored {{ $score }} out of {{ $quiz->num_questions }}.</p>
    </div>
</body>
</html>
