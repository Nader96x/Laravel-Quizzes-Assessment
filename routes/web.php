<?php

use Illuminate\Http\Request;
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
//    Route::resource('/users', 'UserController');
});

Route::put('/answers', 'AnswerController@update')->name("answers.update")->middleware("auth");
Route::resource('/exams', 'ExamController')->middleware('auth');


Auth::routes();
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return to_route("login");
})->name('logout');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
