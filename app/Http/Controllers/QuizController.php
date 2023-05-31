<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function startQuiz(Request $request)
    {
        // Validation
        $request->validate([
            'subject' => 'required|string|max:255',
        ]);

        // Create a new Quiz with the given subject
        $quiz = Quiz::create(['subject' => $request->subject]);

        // Generate 15 questions and save them to the database
        for ($i = 0; $i < 15; $i++) {
            $generatedQuestion = $this->openAIService->generateQuestion($request->subject);

            // Note: Here you will need to parse the generatedQuestion to get the question and answer.
            // This will depend on how the OpenAI API formats its response.
            // This is just an example.
            $questionText = $generatedQuestion['question'];
            $answer = $generatedQuestion['answer'];

            Question::create([
                'quiz_id' => $quiz->id,
                'question' => $questionText,
                'answer' => $answer
            ]);
        }

        // Redirect to the first question
        return redirect()->route('quiz.showQuestion', ['quiz' => $quiz->id, 'questionNumber' => 1]);
    }

    public function showQuestion(Quiz $quiz, $questionNumber)
    {
        $question = $quiz->questions()->skip($questionNumber - 1)->first();

        // Render the question view
        return view('question', ['question' => $question]);
    }

    public function submitAnswer(Quiz $quiz, $questionNumber, Request $request)
    {
        // Validate the submitted answer
        $request->validate([
            'answer' => 'required|string',
        ]);

        // Retrieve the question
        $question = $quiz->questions()->skip($questionNumber - 1)->first();

        // Check the submitted answer against the correct answer
        if ($request->answer === $question->answer) {
            // The answer is correct

            // Retrieve the current score from the session, or 0 if no score has been recorded yet
            $score = session('score', 0);

            // Increment the score
            $score++;

            // Store the new score in the session
            session(['score' => $score]);
        }

        // Determine the next question number
        $nextQuestionNumber = $questionNumber + 1;

        if ($nextQuestionNumber > $quiz->questions->count()) {
            // The quiz is over

            // Retrieve the final score from the session
            $finalScore = session('score', 0);

            // Clear the score from the session
            session()->forget('score');

            // Redirect to the results page
            return redirect()->route('quiz.results', ['quiz' => $quiz->id, 'score' => $finalScore]);
        } else {
            // There are more questions to answer

            // Redirect to the next question
            return redirect()->route('quiz.showQuestion', ['quiz' => $quiz->id, 'questionNumber' => $nextQuestionNumber]);
        }
    }

    public function results(Quiz $quiz, $score)
    {
        return view('result', ['score' => $score]);
    }

}
