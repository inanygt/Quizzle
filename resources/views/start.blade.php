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
<form method="POST" action="/quiz/start">
    @csrf
    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject">

    <label for="num_questions">Number of Questions:</label>
    <input type="number" id="num_questions" name="num_questions">

    <label for="time_per_question">Time per Question (seconds):</label>
    <input type="number" id="time_per_question" name="time_per_question">

    <label for="language">Language:</label>
    <select id="language" name="language">
        <option value="en">English</option>
        <option value="es">Spanish</option>
        <option value="nl">Dutch</option>
        <!-- add other languages here -->
    </select>

    <button type="submit">Start Quiz</button>
</form>
</div>


</body>
</html>
