<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Quiz;

class HomeController extends Controller
{
    public function index() {
        $quiz = new Quiz();
        $quizzes = $quiz->getMostPlayedQuizzes();

    return view('home', compact('quizzes'));
    }
}
