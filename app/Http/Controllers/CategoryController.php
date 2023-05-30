<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Quiz;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index() {

        $categories = Category::all();


        $quiz = Quiz::find(1);


        dd($quiz->category);

        return view('components/discover', compact('categories'));

    }
}
