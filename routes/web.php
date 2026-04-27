<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

/* ── PUBLIC ─────────────────────────────────────────────── */
Route::get('/',     [HomeController::class, 'index'])->name('home');
Route::get('/quiz', [HomeController::class, 'quiz'])->name('quiz');

/* ── ADMIN AUTH ─────────────────────────────────────────── */
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get( 'login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login',  [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    /* ── PROTECTED ADMIN ROUTES ─────────────────────────── */
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Quiz Questions
        Route::get('quiz',                   [QuizController::class, 'index'])->name('quiz.index');
        Route::get('quiz/create',            [QuizController::class, 'create'])->name('quiz.create');
        Route::post('quiz',                  [QuizController::class, 'store'])->name('quiz.store');
        Route::get('quiz/{quiz}/edit',       [QuizController::class, 'edit'])->name('quiz.edit');
        Route::put('quiz/{quiz}',            [QuizController::class, 'update'])->name('quiz.update');
        Route::delete('quiz/{quiz}',         [QuizController::class, 'destroy'])->name('quiz.destroy');
        Route::patch('quiz/{quiz}/toggle',   [QuizController::class, 'toggleActive'])->name('quiz.toggle');

        // Courses
        Route::get('courses',                       [CourseController::class, 'index'])->name('courses.index');
        Route::get('courses/create',                [CourseController::class, 'create'])->name('courses.create');
        Route::post('courses',                      [CourseController::class, 'store'])->name('courses.store');
        Route::get('courses/{course}/edit',         [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('courses/{course}',              [CourseController::class, 'update'])->name('courses.update');
        Route::delete('courses/{course}',           [CourseController::class, 'destroy'])->name('courses.destroy');
        Route::patch('courses/{course}/toggle',     [CourseController::class, 'toggleActive'])->name('courses.toggle');

        // Materials
        Route::get('materials',                     [MaterialController::class, 'index'])->name('materials.index');
        Route::get('materials/create',              [MaterialController::class, 'create'])->name('materials.create');
        Route::post('materials',                    [MaterialController::class, 'store'])->name('materials.store');
        Route::get('materials/{material}/edit',     [MaterialController::class, 'edit'])->name('materials.edit');
        Route::put('materials/{material}',          [MaterialController::class, 'update'])->name('materials.update');
        Route::delete('materials/{material}',       [MaterialController::class, 'destroy'])->name('materials.destroy');
        Route::patch('materials/{material}/toggle', [MaterialController::class, 'toggleActive'])->name('materials.toggle');

        // Settings
        Route::get('settings',  [SettingController::class, 'index'])->name('settings');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
