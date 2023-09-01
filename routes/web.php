<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

// auth + role admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/quizzes', 'QuizController');
    Route::resource('/questions', 'QuestionController');
    Route::resource('/users', 'UserController');
});

Route::resource('/answers', 'AnswerController');
Route::resource('/exams', 'ExamController')->middleware('auth');


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
