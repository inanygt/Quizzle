<h1>{{ $quiz->name }} - Results</h1>
<p>Your score: {{ $score }}</p>

<form method="POST" action="{{ route('quizzle.rateQuiz', ['quiz' => $quiz->id]) }}">
    @csrf
    <label for="rating">Rate this quiz:</label>
    <select name="rating" id="rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    <button type="submit">Submit</button>
</form>

<a href="http://localhost:8000/">Back to Dashboard</a>
