<?php
use Illuminate\Support\Facades\Route;
use App\Http\controllers\FrontController;

// Public routes
// Route::get('/dashboard', [FrontController ::class , 'test']);
Route::get('/', [FrontController ::class , 'loginPage'])->name("login");
Route::get('/register', [FrontController ::class , 'registerPage']);

Route::post('/post-Form', [FrontController ::class , 'post_Form']);
Route::post('/post-Login', [FrontController ::class , 'post_Login']);


// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/studentList', [FrontController ::class , 'studentList']);
    Route::post('/form-Data', [FrontController ::class , 'studentForm']);
    Route::get('/dashboard', [FrontController::class, 'test']);
    Route::get('/logout', [FrontController::class, 'logout']);
});
