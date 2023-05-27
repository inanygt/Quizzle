<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index() {

        $categories = Category::all();

        return view('components/discover', compact('categories'));

    }
}
