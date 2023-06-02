<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizzleController extends Controller
{
    public function form(Request $request) {
        // dd($request);

        $validation = $request->validate([
             'name' => 'required',
             'category_id' => 'required'
        ]);

        $quiz = Quiz::create($validation);


        return view('quizzle');
    }
}
