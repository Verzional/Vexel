<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RubricController;
use App\Models\Assignment;
use App\Models\Rubric;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD ---
Route::get('/dashboard', function () {

    // 1. STATISTIK (Count Data Real)
    $totalRubrics = Rubric::count();
    $totalAssignments = Assignment::count();
    $totalSubmissions = DB::table('submissions')->count();

    // 2. RECENT ACTIVITY

    // A. Aktivitas Rubric
    $rubricActivities = Rubric::latest('updated_at')->take(5)->get()->map(function ($item) {
        return (object) [
            'name' => $item->subject_name,
            'date' => $item->updated_at,
            'type' => 'Rubric',
        ];
    });

    // B. Aktivitas Assignment
    $assignmentActivities = Assignment::latest('updated_at')->take(5)->get()->map(function ($item) {
        return (object) [
            'name' => $item->title,
            'date' => $item->updated_at,
            'type' => 'Assignment',
        ];
    });

    // C. Aktivitas Submission
    $submissionActivities = DB::table('submissions')->orderBy('created_at', 'desc')->take(5)->get()->map(function ($item) {
        return (object) [
            'name' => 'Submission #'.$item->id,
            'date' => \Carbon\Carbon::parse($item->created_at),
            'type' => 'Submission',
        ];
    });

    // 3. GABUNG & URUTKAN
    $allActivities = $rubricActivities
        ->concat($assignmentActivities)
        ->concat($submissionActivities)
        ->sortByDesc('date')
        ->take(10);

    // 4. KIRIM KE VIEW
    return view('dashboard', [
        'totalRubrics' => $totalRubrics,
        'totalAssignments' => $totalAssignments,
        'totalSubmissions' => $totalSubmissions,
        'activities' => $allActivities,
    ]);

})->middleware(['auth', 'verified'])->name('dashboard');

// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resources
    Route::resource('rubrics', RubricController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::resource('submissions', \App\Http\Controllers\SubmissionController::class);
    Route::get('submissions/{submission}/download', [SubmissionController::class, 'download'])->name('submissions.download')->middleware('auth');
    Route::post('submissions/{submission}/grade', [GradingController::class, 'grade'])->name('submissions.grade')->middleware('auth');
});

require __DIR__.'/auth.php';
