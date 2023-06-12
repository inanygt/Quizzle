<?php

namespace App\Http\Controllers;

// Models

use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class QuizzleController extends Controller
{

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
        $correctAnswers = $request->correctAnswers;

        // dd($request);

      // Create and associate the child models (Questions)
foreach ($questions as $index => $questionData) {
    $question = new Question();
    $question->question = $questionData;
    $question->quiz_id = $quiz->id; // Assign the quiz_id
    $question->correct_answer = $correctAnswers[$index];
    $question->save();

    // Associate the Question with the Quiz
    $quiz->questions()->save($question);

    // Create and associate the child models (Answers)
    $startIndex = $index * 4; // Starting index for answers
    $answerData = array_slice($answers, $startIndex, 4); // Get the answers for this question

    foreach ($answerData as $answer) {
        $answerModel = new Answer();
        $answerModel->answer = $answer;
        $answerModel->question_id = $question->id; // Assign the question_id
        $answerModel->save();

        // Associate the Answer with the Question
        $question->answers()->save($answerModel);
    }
}


    // foreach ($answers as $index => $answerData) {
    //     $answer = new Answer();
    //     $answer->answer = $answerData;
    // }





    //     try {



    //     }

    //     } catch (QueryException $e) {
    //     $errorCode = $e->errorInfo[1];
    //     if ($errorCode == 1062) {
    //         // Duplicate entry error
    //         $errorMessage = 'This account already exists already exists.';
    //         return view('/quizzle', ['errorMessage' => $errorMessage]);
    //     }
    //     // Other database error
    //     $errorMessage = 'An error occurred.';
    //     return view('/quizzle', ['errorMessage' => $errorMessage]);
    // }


    // return view('quizzle', ['name' => $request->name]);
    return view('quizzle', compact('categories', 'name'));
    }
}


