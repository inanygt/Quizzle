<?php

namespace App\Http\Controllers;

// Models
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

    $questionQuiz = $request->questions;
    $correct_answer = $request->correct_answer;

    // Associate the child model with the parent model
    foreach ($questionQuiz as $index => $questionQuiz) {
        $question = new Question(['question' => $questionQuiz, 'correct_answer' => $correct_answer[$index]]);
        $quiz->questions()->save($question);
}

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


