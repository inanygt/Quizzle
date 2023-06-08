<?php

namespace App\Http\Controllers;

// Models

use App\Models\Quiz;
use App\Models\Question;

use Illuminate\Http\Request;

class GeographyController extends Controller
{
    //
    public function play($id) {

        // get all questions with the quiz id from the url
        $quiz = Quiz::find($id);
        $questions = $quiz->questions;
        // Get all answers from the related question
        $id = $questions[0]->id;
        // dd($questions[0]->id);
        $question = Question::find($id);
        $answers = $question->answers;

        return view('categories.geographyquizzle', compact('id', 'questions', 'answers'));
    }

    public function index() {
    // Get all quizzes with category from relation
    $quizzes = Quiz::where('category_id', 1)->get();
    return view('categories/geography', compact('quizzes'));
    }


}
