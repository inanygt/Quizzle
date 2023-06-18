<?php

namespace App\Http\Controllers;

// Models
use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Session;
use Illuminate\Support\Facades\Route;
use App\Services\OpenAiService;
use Log;

use App\Models\AiQuiz;
use App\Models\AiQuestion;
use App\Models\AiAnswer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;




class QuizzleController extends Controller
{

    private $openAiService;

public function __construct(OpenAiService $openAiService)
{
    $this->openAiService = $openAiService;
}


    public function index() {
        $categories = Category::all();
        return view('quizzle', compact('categories'));
    }

    public function random() {

        // Get random quiz
        // $randomQuiz = Quiz::inRandomOrder()->first();
        $randomQuiz = Quiz::find(4);
        // dd($randomQuiz);
        $quizId = $randomQuiz->id;
        // get related questions from the random quiz
        $quiz = Quiz::with('questions.answers')->find($quizId);

        return view('playquizzle', compact('randomQuiz', 'quiz'));
    }

    public function postRandom(Request $request) {
        dd($request);
    }

    public function form(Request $request) {

        $categories = Category::all();

        $validation = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'subject' => 'required',
            'approved' => 'required'
        ]);

        $name = $request->name;
        $quiz = Quiz::create($validation);

        $questions = $request->questions;
        $answers = $request->answers;

        foreach ($questions as $index => $questionText) {
            $question = new Question();
            $question->question = $questionText;
            $question->quiz_id = $quiz->id;
            $question->save();

            // Create and associate the child models (Answers)
            $answerData = $answers[$index];

            foreach ($answerData as $answerItem) {
                $answer = new Answer();
                $answer->text = $answerItem['text'];
                $answer->question_id = $question->id;
                $answer->is_correct = $answerItem['is_correct'] ?? false;
                $answer->save();
            }
        }

        return view('quizzle', compact('categories', 'name'));
    }

    public function showQuizzes() {
        $quizzes = Quiz::all();
        return view('play', compact('quizzes'));
    }

    public function initiateQuiz($quizId)
    {
        // Initialize the quiz and store it in the session
        $quiz = Quiz::with(['questions', 'questions.answers'])->findOrFail($quizId);

        Session::put('quiz', $quiz);
        Session::put('question_number', 0); // number of the current question
        Session::put('score', 0); // user's score

        return redirect()->route('quizzle.nextQuestion');
    }

    public function nextQuestion()
    {
        $quiz = Session::get('quiz');
        $question_number = Session::get('question_number');

        if ($question_number < count($quiz->questions)) {
            $nextQuestion = $quiz->questions[$question_number];
            Session::put('question_number', $question_number + 1); // update the number of the current question

            return view('quizzlequestion', compact('quiz', 'nextQuestion'));
        } else {
            return redirect()->route('quizzle.displayResult', ['quiz' => $quiz->id]);
        }
    }

    public function processAnswer(Request $request)
    {
        $validated = $request->validate([
            'questionId' => 'required|exists:questions,id',
            'answerId' => 'required|exists:answers,id',
        ]);

        $quiz = Session::get('quiz');
        $question_number = Session::get('question_number');
        $question = $quiz->questions[$question_number - 1]; // get the current question

        if ($validated['questionId'] != $question->id) {
            return back()->withErrors('Invalid question');
        }

        $answer = Answer::find($validated['answerId']);
        if ($answer->question_id != $question->id) {
            return back()->withErrors('Invalid answer');
        }

        if ($answer->is_correct) {
            Session::increment('score'); // update the user's score
        }

        return redirect()->route('quizzle.nextQuestion'); // proceed to the next question
    }

    public function displayResult()
    {
        // Fetch the score from the session
        $score = Session::get('score', 0);
        $quiz = Session::get('quiz');

        // After displaying result, clear the score for next quiz
        Session::forget('score');
        Session::forget('question_number');
        Session::forget('quiz');

        // Display the result
        return view('quizzleresult', ['quiz' => $quiz, 'score' => $score]);
    }

    public function rateQuiz(Request $request, $quizId)
{
    $quiz = Quiz::findOrFail($quizId);

    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $quiz->rating = $validated['rating'];
    $quiz->save();

    return back()->with('message', 'Thank you for rating this quiz!');
}


public function generateAiQuiz(Request $request)
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

    $quiz = $quiz->load(['questions.answers']);

    // Flash the quiz data to the session
    return redirect('/quizzle')->with('quiz', $quiz);
    // return redirect('/quizzle')->with('quiz', $quiz);
}


    public function getLatestQuiz() {
        $quiz = AIQuiz::with(['questions.answers'])->latest()->first();

        return response()->json($quiz);
    }

    public function getAiQuiz($quizId)
    {
        $aiQuiz = AiQuiz::with('questions.answers')->find($quizId);

        if (!$aiQuiz) {
            return response()->json(['error' => 'Quiz not found'], 404);
        }

        $aiQuizArray = $aiQuiz->toArray();

        return response()->json($aiQuizArray);
    }


}
