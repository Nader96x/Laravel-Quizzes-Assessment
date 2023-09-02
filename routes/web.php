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
Route::middleware(['auth'])->group(function () {
    Route::resource('/quizzes', 'QuizController')->middleware("role:admin");
    Route::post('/quizzes/{id}/restore', 'QuizController@restore')->name("quizzes.restore")->middleware("role:admin");
    Route::resource('/questions', 'QuestionController')->middleware("role:admin");
    Route::put('/answers', 'AnswerController@update')->name("answers.update");
    Route::resource('/exams', 'ExamController');
    Route::post('/exams/{exam}/sendmail', 'ExamController@sendmail')->name("exams.sendmail");
});


Auth::routes();
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return to_route("login");
})->name('logout');

Route::get('/', 'HomeController@index')->name('home');
