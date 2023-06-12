<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Models
use App\Models\Category;
use App\Models\Quiz;

// Controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuizController;

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



// jorianAPItest 1

// Route::get('/quiz/start', function () {
//     return view('start');
// });
// Route::post('/quiz/start', [QuizController::class, 'startQuiz']);
// Route::get('/quiz/{quiz}/question/{questionNumber}', [QuizController::class, 'showQuestion'])->name('quiz.showQuestion');
// Route::post('/quiz/{quiz}/question/{questionNumber}', [QuizController::class, 'submitAnswer']);
// Route::get('/quiz/{quiz}/results/{score}', [QuizController::class, 'results'])->name('quiz.results');

// Route::post('/quiz/{quiz}/question/{questionNumber}', [QuizController::class, 'submitAnswer'])->name('quiz.submitAnswer');

// //Jorian joinQuiz
// Route::get('/join', [QuizController::class, 'showJoinPage']);
// Route::post('/join', [QuizController::class, 'joinQuiz']);

// Route::get('/quiz/{quiz}/start', [QuizController::class, 'startQuiz'])->name('quiz.start');


// JorianApitest 2
Route::get('/quiz/start', function () {
    return view('start');
});

Route::post('/quiz/start', [QuizController::class, 'startQuiz']);

Route::post('/quiz/{quiz}/question/{question}', [QuizController::class, 'submitAnswer'])->name('quiz.submitAnswer');

Route::get('quiz/{quiz}/results', [QuizController::class, 'results'])->name('quiz.results');

Route::get('/quiz/{quiz}/question/{questionNumber}', [QuizController::class, 'showQuestion'])->name('quiz.showQuestion');
Route::get('/quiz/{quiz}/result', [QuizController::class, 'showResult'])->name('quiz.showResult');


// Route::get('/quiz/{quiz_id}/question/{question_number}', [QuizController::class, 'showQuestion'])->name('quiz.showQuestion');
// Route::post('/quiz/{quiz_id}/nextQuestion', [QuizController::class, 'nextQuestion'])->name('quiz.nextQuestion');





//inan
// Categories
Route::get('/geography', function() {
    // Get all quizzes with category from relation
    $quizzes = Quiz::where('category_id', 1)->get();

    return view('categories/geography', compact('quizzes'));
})->name('geography');

Route::get('/music', function() {
    $quizzes = Quiz::where('category_id', 2)->get();
    return view('categories/music', compact('quizzes'));
})->name('music');

Route::get('/math', function() {
    $quizzes = Quiz::where('category_id', 3)->get();

    return view('categories/math', compact('quizzes'));
})->name('math');


//inan
// Categories
Route::get('/geography', function() {
    // Get all quizzes with category from relation
    $quizzes = Quiz::where('category_id', 1)->get();

    return view('categories/geography', compact('quizzes'));
})->name('geography');

Route::get('/music', function() {
    $quizzes = Quiz::where('category_id', 2)->get();
    return view('categories/music', compact('quizzes'));
})->name('music');

Route::get('/math', function() {
    $quizzes = Quiz::where('category_id', 3)->get();

    return view('categories/math', compact('quizzes'));
})->name('math');


require __DIR__.'/auth.php';
