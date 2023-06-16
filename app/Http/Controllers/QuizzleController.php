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



class QuizzleController extends Controller
{

    public function index() {
        $categories = Category::all();
        return view('quizzle', compact('categories'));
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

}
