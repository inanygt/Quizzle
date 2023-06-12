<?php

namespace App\Http\Controllers;

use App\Models\AiQuiz;
use App\Models\AiQuestion;
use App\Models\AiAnswer;
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
        $quiz = AiQuiz::create([
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
                    $answerText = $answerData['text'];
                    $isCorrect = $answerData['is_correct'];

                    // If the answer is correct, remove the 'Correct Answer:' part from the answer
                    if ($isCorrect) {
                        $answerText = str_replace('Correct Answer:', '', $answerText);
                    }

                    $answer = $question->answers()->create([
                        'text' => $answerText,
                        'is_correct' => $isCorrect,
                    ]);

                    Log::info('Created Answer:', $answer->toArray()); // Log each answer created
                }
            }
        });

        return redirect()->route('quiz.showQuestion', ['quiz' => $quiz->id, 'questionNumber' => 1]);
    }

    public function showQuestion(AiQuiz $quiz, int $questionNumber)
    {
        $question = $quiz->questions()->skip($questionNumber - 1)->first();

        if ($question === null) {
            // handle the error, maybe redirect to the result page
            return redirect()->route('quiz.showResult', ['quiz' => $quiz->id]);
        }

        return view('question', ['quiz' => $quiz, 'questionNumber' => $questionNumber, 'question' => $question]);
    }

    public function submitAnswer(Request $request, AiQuiz $quiz, int $questionNumber)
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

        if ($questionNumber < $quiz->questions()->count()) {
            return redirect()->route('quiz.showQuestion', ['quiz' => $quiz->id, 'questionNumber' => $questionNumber + 1]);
        } else {
            // if it was the last question, increment the score by 0
            Session::put('score', Session::get('score') + 0);
            return redirect()->route('quiz.showResult', ['quiz' => $quiz->id]);
        }
    }

    public function showResult(AiQuiz $quiz)
    {
        // Fetch the score from the session
        $score = Session::get('score', 0);

        return view('result', ['quiz' => $quiz, 'score' => $score]);
    }
}
