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
        $correctAnswers = $request->correct_answer;
        $answers = $request->answers;

        // Create an array to store the created questions and answers
        $createdQuestions = [];
        $createdAnswers = [];

        // dd($request);
        // // Associate the child model with the parent model
        foreach ($questions as $index => $questionText) {
            $question = new Question(['question' => $questionText, 'correct_answer' => $correctAnswers[$index]]);
            $quiz->questions()->save($question);
        }
        foreach($answers as $answers) {
            $answer = new Answer(['answer' => $answers]);
            $question->answers()->save($answer);
        }

//         // Loop through the questions and create/update them
// foreach ($questions as $index => $questionText) {
//     // Create or update the question based on the index
//     $question = Question::updateOrCreate(['id' => $index], [
//         'question' => $questionText,
//         'quiz_id' => $quiz->id,
//         'correct_answer' => $correctAnswers[$index]
//         // Add other attributes as needed
//     ]);

//     // Add the question to the createdQuestions array
//     $createdQuestions[] = $question;

//     // Determine the starting index for the answers related to this question
//     $answerStartIndex = $index * 3;

//     // Loop through the answers and create/update them
//     for ($i = $answerStartIndex; $i < $answerStartIndex + 3; $i++) {
//         // Create or update the answer based on the index
//         $answer = Answer::updateOrCreate(['id' => $i], [
//             'question_id' => $question->id,
//             'answer' => $answers[$i],
//             // Add other attributes as needed
//         ]);

//         // Add the answer to the createdAnswers array
//         $createdAnswers[] = $answer;
//     }

//     // Set the correct answer for the question
//     $question->correct_answer = $correctAnswers[$index];
//     $question->save();
// }

// Use the $createdQuestions and $createdAnswers arrays as needed



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


