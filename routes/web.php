<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Models
use App\Models\Category;
use App\Models\Quiz;

// Controllers
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/quiz', function() {
    return view('quiz');
})->name('fuzzle');

// Route::get('/discover', function() {
//     return view('components/discover');
// })->name('discover');

Route::get('/discover', [CategoryController::class, 'index'])->name('discover');


// Categories
Route::get('/geography', function() {
    // Get all quizzes with category from relation
    $quizzes = Quiz::where('category_id', 1)->get();

    return view('categories/geography', compact('quizzes'));
})->name('geography');

Route::get('/music', function() {
    return view('categories/music');
})->name('music');

Route::get('/math', function() {
    return view('categories/math');
})->name('math');

require __DIR__.'/auth.php';
