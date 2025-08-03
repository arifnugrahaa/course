<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/about', [DashboardController::class, 'about']);
Route::get('/course', [DashboardController::class, 'course']);
Route::get('/instructors', [DashboardController::class, 'instruktur']);
Route::get('/contact', [DashboardController::class, 'contact']);

Auth::routes(['register' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::resource('materials', MaterialController::class);
    // Route::post('materials/approve', [MaterialController::class, 'approve'])->name('materials.approve');
    Route::post('materials/approve/{material}', [MaterialController::class, 'approve'])->name('materials.approve');
    Route::post('materials/reject/{material}', [MaterialController::class, 'reject'])->name('materials.reject');

    // Comment routes
    Route::post('materials/{material}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// // Admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/pending', [AdminController::class, 'pendingMaterials'])->name('admin.pending');
});


Route::post('/upload-image', function (Request $request) {
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $path = $file->store('uploads', 'public');

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }

    return response()->json(['error' => 'No file uploaded.'], 400);
});
