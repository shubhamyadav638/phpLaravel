<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\FrontController;

// Public routes
// Route::get('/dashboard', [FrontController ::class , 'test']);
Route::get('/', [FrontController::class, 'loginPage'])->name("login");
Route::get('/register', [FrontController::class, 'registerPage']);

Route::post('/post-Form', [FrontController::class, 'post_register']);
Route::post('/post-Login', [FrontController::class, 'post_Login']);

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [FrontController::class, 'logout']);

    Route::get('/dashboard', [FrontController::class, 'mainpage']);

    // ============================ student ================================

    Route::get('/add-student-form', [FrontController::class, 'addStudentForm']);
    Route::post('/form-Data', [FrontController::class, 'studentForm']);

    // Route::get('/studentList', [FrontController ::class , 'studentList']);
    // yajra datatable
    Route::get('/student-list', [FrontController::class, 'student_list']);


    Route::get('/edit-student-form/{id}', [FrontController::class, 'editStudentForm']);
    Route::post('/update-form-Data', [FrontController::class, 'updateFormData']);

    Route::get('/delete-form-Data/{id}', [FrontController::class, 'deleteStudentForm']);

    //=========================== teacher =================================

    Route::get('/add-teacher-form', [FrontController::class, 'add_teacher']);
    Route::post('/save-teacher-form', [FrontController::class, 'save_teacher']);

    Route::get('/teacher-list-form', [FrontController::class, 'teacher_list']);

    Route::get('/edit-teacher-form/{id}', [FrontController::class, 'edit_teacher_form']);
    Route::post('/update-teacher-form', [FrontController::class, 'update_Teacher_FormData']);

    Route::get('/delete-teacher-Data/{id}', [FrontController::class, 'delete_Teacher_Form']);



    //================================ HOD ==============================
    Route::get('/add-hod-form', [FrontController::class, 'add_hod']);
    Route::get('/edit-hod-form/{id}', [FrontController::class, 'edit_hod']);
    Route::get('/hod-list-form', [FrontController::class, 'list_hod']);
    Route::post('/post-hod', [FrontController::class, 'post_hod']);
    Route::post('/update-hod', [FrontController::class, 'update_hod']);
    Route::get('/delete-hod/{id}', [FrontController::class, 'delete_hod']);
});