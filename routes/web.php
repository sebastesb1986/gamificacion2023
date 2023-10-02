<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Survey\SurveyController;
use App\Http\Controllers\Survey\QuestionController;
use App\Http\Controllers\Survey\AnswerController;
use App\Http\Controllers\Survey\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


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
    return view('welcome');
});



// Auth routes
Route::get('login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class , 'login']);
Route::post('logout', [LoginController::class , 'logout'])->name('logout');

// Registration Routes...
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/people', [HomeController::class, 'people'])->name('home.people');
Route::post('/people', [HomeController::class, 'store'])->name('register.people');

 // Question
 Route::get('question', [QuestionController::class, 'index'])->name('question.index');
 Route::get('showQuestion/{count}', [QuestionController::class, 'show'])->name('question.show');
 Route::post('createQuestion', [QuestionController::class, 'store'])->name('question.create');
 Route::put('updateQuestion/{id}', [QuestionController::class, 'update'])->name('question.update');
 Route::delete('deleteQuestion/{id}', [QuestionController::class, 'delete'])->name('question.delete');

 // Answer
 Route::get('getContent', [AnswerController::class, 'getContent'])->name('answer.content');
 Route::get('showResultGamer/{gmrId}', [UserController::class, 'showResultGamer'])->name('gamer.result');
 Route::post('saveResultsGamer', [UserController::class, 'resultGamer'])->name('answer.results');
 Route::get('getContentAns/{gmrId}/{qstId}', [AnswerController::class, 'getAnswerGamer'])->name('answer.gamer');

 Route::get('answer', [AnswerController::class, 'index'])->name('answer.index');
 Route::get('allanswer', [AnswerController::class, 'allAnswer'])->name('answer.all');
 Route::get('showAnswer/{id}', [AnswerController::class, 'show'])->name('answer.show');
 Route::post('saveAnswer', [AnswerController::class, 'store'])->name('answer.save');
 Route::put('updateanswer/{id}', [AnswerController::class, 'update'])->name('answer.update');
 Route::delete('deleteAnswer/{id}', [AnswerController::class, 'delete'])->name('answer.delete');

// End Auth routes

Route::group([

    'middleware' => 'web',
    'prefix' => 'auth'

], function ($router) {

    // Sign in and admin User
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('showUs', [UserController::class, 'show'])->name('user.show');
    // Route::post('register', [UserController::class, 'store'])->name('user.store');
    Route::put('updateUs/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('deleteUs/{id}', [UserController::class, 'delete'])->name('user.delete');

    Route::get('gamer/{id}', [UserController::class, 'index'])->name('gamer.index');
   


    Route::get('/categories/gamer', [CategoryController::class, 'index'])->name('categ.index');
    Route::get('gamer/categories/{id}', [UserController::class, 'gamerByCategs'])->name('gamer.categs');

    Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
    Route::post('/survey/{gamer}', [SurveyController::class, 'guardar'])->name('answer.save');
});
