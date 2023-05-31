<form method="POST" action="/quiz/start">
    @csrf
    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject">
    <button type="submit">Start Quiz</button>
</form>
