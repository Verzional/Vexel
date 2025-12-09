<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('rubrics', RubricController::class)->middleware('auth');
Route::resource('assignments', AssignmentController::class)->middleware('auth');
Route::resource('submissions', SubmissionController::class)->middleware('auth');
Route::get('submissions/{submission}/download', [SubmissionController::class, 'download'])->name('submissions.download')->middleware('auth');
Route::post('submissions/{submission}/grade', [GradingController::class, 'grade'])->name('submissions.grade')->middleware('auth');

require __DIR__.'/auth.php';
