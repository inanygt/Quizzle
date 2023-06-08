<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Services\OpenAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Log;
use Session;

class QuizController extends Controller
{
    private $openAiService;

    public function __construct(OpenAiService $openAiService)
    {
        $this->openAiService = $openAiService;
    }

    public function startQuiz(Request $request)
    {
        Session::put('score', 0);
        $subject = $request->input('subject');
        $numQuestions = $request->input('num_questions');

        // Generate the questions and answers
        $quizData = $this->openAiService->generateQuestion($subject, $numQuestions);

        // Log the quiz data received from the OpenAI service
        Log::info('Received Quiz Data:', $quizData);

        // Create the quiz
        $quiz = Quiz::create([
            'subject' => $subject,
            'num_questions' => $numQuestions,
        ]);

        // Log the created quiz
        Log::info('Created Quiz:', $quiz->toArray());

        // Create the questions and answers using a transaction
        DB::transaction(function () use ($quiz, $quizData) {
            foreach ($quizData as $questionData) {
                Log::info('Processing Question:', $questionData); // Log each question being processed

                $questionText = $questionData['question'];

                $question = $quiz->questions()->create([
                    'text' => $questionText,
                ]);

                Log::info('Created Question:', $question->toArray()); // Log each question created

                foreach ($questionData['answers'] as $answerData) {
                    $answer = $question->answers()->create([
                        'text' => $answerData['text'],
                        'is_correct' => $answerData['is_correct'],
                    ]);

                    Log::info('Created Answer:', $answer->toArray()); // Log each answer created
                }
            }
        });

        return redirect()->route('quiz.showQuestion', ['quiz' => $quiz->id, 'questionNumber' => 1]);
    }

    public function showQuestion(Quiz $quiz, int $questionNumber)
    {
        $question = $quiz->questions()->skip($questionNumber - 1)->first();

        if ($question === null) {
            // handle the error, maybe redirect to the result page
            return redirect()->route('quiz.showResult', ['quiz' => $quiz->id]);
        }

        return view('question', ['quiz' => $quiz, 'questionNumber' => $questionNumber, 'question' => $question]);
    }

    public function submitAnswer(Request $request, Quiz $quiz, int $questionNumber)
    {
        // if the session does not have 'score', set it to 0
        if (!Session::has('score')) {
            Session::put('score', 0);
        }

        $validated = $request->validate([
            'answer' => 'required|integer',
        ]);

        $question = $quiz->questions()->skip($questionNumber - 1)->first();
        $correctAnswer = $question->answers()->where('is_correct', true)->first();

        if ($correctAnswer->id == $request->input('answer')) {
            // if the answer is correct, increment the score
            Session::put('score', Session::get('score') + 1);
        }

        if ($questionNumber < $quiz->num_questions) {
            return redirect()->route('quiz.showQuestion', ['quiz' => $quiz->id, 'questionNumber' => $questionNumber + 1]);
        } else {
            // if it was the last question, redirect to the result page
            return redirect()->route('quiz.showResult', ['quiz' => $quiz->id]);
        }
    }

    public function showResult(Quiz $quiz)
{
    // Fetch the score from the session
    $score = Session::get('score', 0);

    return view('result', ['quiz' => $quiz, 'score' => $score]);
}


    // your other methods...
}
