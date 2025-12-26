<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\SubmissionController;
use App\Models\Assignment;
use App\Models\Rubric;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    // Statistics
    $totalRubrics = Rubric::count();
    $totalAssignments = Assignment::count();
    $totalSubmissions = DB::table('submissions')->count();

    // Rubric Activities
    $rubricActivities = Rubric::latest('updated_at')->take(5)->get()->map(function ($item) {
        return (object) [
            'name' => $item->subject_name,
            'date' => $item->updated_at,
            'type' => 'Rubric',
        ];
    });

    // Assignment Activities
    $assignmentActivities = Assignment::latest('updated_at')->take(5)->get()->map(function ($item) {
        return (object) [
            'name' => $item->title,
            'date' => $item->updated_at,
            'type' => 'Assignment',
        ];
    });

    // Submission Activities
    $submissionActivities = DB::table('submissions')->orderBy('created_at', 'desc')->take(5)->get()->map(function ($item) {
        return (object) [
            'name' => 'Submission #'.$item->id,
            'date' => \Carbon\Carbon::parse($item->created_at),
            'type' => 'Submission',
        ];
    });

    // Merge & Sort Activities
    $allActivities = $rubricActivities
        ->concat($assignmentActivities)
        ->concat($submissionActivities)
        ->sortByDesc('date')
        ->take(10);

    // Send to View
    return view('dashboard', [
        'totalRubrics' => $totalRubrics,
        'totalAssignments' => $totalAssignments,
        'totalSubmissions' => $totalSubmissions,
        'activities' => $allActivities,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resources
    Route::resource('courses', CourseController::class);
    Route::resource('rubrics', RubricController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::resource('submissions', SubmissionController::class);

    // Download Submission
    Route::get(
        'submissions/{submission}/download',
        [SubmissionController::class, 'download']
    )->name('submissions.download');

    // Grade Submission
    Route::post('/submissions/{submission}/grade', [GradingController::class, 'grade'])
        ->name('submissions.grade');
});

require __DIR__.'/auth.php';
