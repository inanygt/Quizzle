<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Quiz;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // Use 'with' to eager load quizzes for each category in one database query
        // This helps improve performance by avoiding the 'N+1 query' problem
        $categories = Category::with('quizzes')->get();

        return view('components/discover', compact('categories'));
    }
}


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// // Models
// use App\Models\Quiz;
// use App\Models\Category;

// class CategoryController extends Controller
// {
//     //
//     public function index()
//     {

//         $categories = Category::all();


//         $quiz = Quiz::find(1);


//         // dd($quiz->category);

//         return view('components/discover', compact('categories'));

//     }
// }
