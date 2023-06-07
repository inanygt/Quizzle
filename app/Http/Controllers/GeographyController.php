<?php

namespace App\Http\Controllers;

// Models
use App\Models\Quiz;

use Illuminate\Http\Request;

class GeographyController extends Controller
{
    //
    public function index() {
    // Get all quizzes with category from relation
    $quizzes = Quiz::where('category_id', 1)->get();
    return view('categories/geography', compact('quizzes'));
    }

    public function play() {

    }
}
