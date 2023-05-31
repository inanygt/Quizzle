<p>{{ $question->question }}</p>

<form method="POST" action="/quiz/{{ $quiz->id }}/question/{{ $questionNumber }}">
    @csrf
    <label for="answer">Your Answer:</label>
    <input type="text" id="answer" name="answer">
    <button type="submit">Submit Answer</button>
</form>
