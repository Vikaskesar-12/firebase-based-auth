<?php
use App\Http\Middleware\FirebaseAuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// ✅ Login Page
Route::get('/', function () {
    return view('login');
})->name('login');

// ✅ Firebase Login Verification (from frontend Firebase Auth)
Route::post('/verify-user', [TaskController::class, 'verifyUser']);

// ✅ Authenticated User Routes
Route::middleware(['firebase.auth'])->group(function () {

    Route::get('/user/dashboard', [TaskController::class, 'index'])->name('user.dashboard');
    Route::get('/user/add-task', [TaskController::class, 'add_task'])->name('add.task.page');
    Route::post('/save-task', [TaskController::class, 'saveTask'])->name('save.task');
});
