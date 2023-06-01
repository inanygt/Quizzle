<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'num_questions' => 'required|integer|min:1',
            'time_per_question' => 'required|integer|min:1',
            'language' => 'required|string|in:en,es', // add other languages here
        ]);

        Log::info('startQuiz method was hit with request data', ['request_data' => $request->all()]);

        // Create a new Quiz with the given subject
        $quiz = Quiz::create([
            'subject' => $request->subject,
            'num_questions' => $request->num_questions,
            'time_per_question' => $request->time_per_question,
            'language' => $request->language
        ]);

        Log::info('Quiz created', ['quiz' => $quiz]);

        // Generate questions and save them to the database
        for ($i = 0; $i < $request->num_questions; $i++) {
            try {
                $generatedQuestion = $this->openAIService->generateQuestion($request->subject);

                Log::info('Generated question', ['generatedQuestion' => $generatedQuestion]);

                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'question' => $generatedQuestion['question'],
                    'choices' => json_encode($generatedQuestion['choices']),
                    'correct_answer' => $generatedQuestion['correct_answer']
                ]);

                Log::info('Question created', ['question' => $question]);
            } catch (\Exception $e) {
                Log::error('Failed to generate question', ['error' => $e->getMessage()]);
                return redirect()->back()->withErrors(['error' => 'Failed to generate question']);
            }
        }

        // Redirect to the first question
        return redirect()->route('quiz.showQuestion', ['quiz' => $quiz->id, 'questionNumber' => 1]);
    }

    public function showQuestion(Quiz $quiz, $questionNumber)
    {
        $question = $quiz->questions()->skip($questionNumber - 1)->first();
        return view('question', ['quiz' => $quiz, 'questionNumber' => $questionNumber, 'question' => $question]);
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
        if ($request->answer == $question->correct_answer) {
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

        if ($nextQuestionNumber > $quiz->num_questions) {
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
