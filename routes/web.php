<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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


Route::get('/testquiz', function (){
$quiz = App\Models\Category::with('quiz')->get();
dd($quiz);
});

// Categories
Route::get('/geography', function() {
    return view('categories/geography');
})->name('geography');

Route::get('/music', function() {
    return view('categories/music');
})->name('music');

Route::get('/math', function() {
    return view('categories/math');
})->name('math');

require __DIR__.'/auth.php';
