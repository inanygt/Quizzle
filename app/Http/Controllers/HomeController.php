<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Quiz;

class HomeController extends Controller
{
    public function index()
    {
        $quiz = new Quiz();
        $pQuizzes = $quiz->getMostPlayedQuizzes();

        $quiz = new Quiz();
        $rQuizzes = $quiz->bestRadedQuizzes();


        return view('home', compact('pQuizzes', 'rQuizzes'));
    }
}
