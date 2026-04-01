<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AttemptController;

Route::get('/', function () {
    return redirect()->route('quizzes.index');
});

// Resource routes for Quizzes
Route::resource('quizzes', QuizController::class);

// Nested resource route for Questions (a question always belongs to a quiz)
Route::resource('quizzes.questions', QuestionController::class)->except(['index']);


Route::get('quizzes/{quiz}/attempt', [AttemptController::class, 'create'])->name('quizzes.attempt');
Route::post('quizzes/{quiz}/attempt', [AttemptController::class, 'store'])->name('quizzes.submit');
Route::get('attempts/{attempt}', [AttemptController::class, 'show'])->name('attempts.show');