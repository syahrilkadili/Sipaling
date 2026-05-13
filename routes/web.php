<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Petugas\PetugasController;

// ─── Root Redirect ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->getDashboardRoute());
    }
    return redirect()->route('login');
});

// ─── Authentication Routes ─────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ─── Admin Routes ──────────────────────────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Reports management
        Route::get('/reports',                  [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}',         [AdminReportController::class, 'show'])->name('reports.show');
        Route::post('/reports/{report}/confirm',[AdminReportController::class, 'confirm'])->name('reports.confirm');
        Route::post('/reports/{report}/reject', [AdminReportController::class, 'reject'])->name('reports.reject');
        Route::post('/reports/{report}/assign', [AdminReportController::class, 'assign'])->name('reports.assign');
        Route::delete('/reports/{report}',      [AdminReportController::class, 'destroy'])->name('reports.destroy');

        // User management
        Route::get('/users',              [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create',       [UserController::class, 'create'])->name('users.create');
        Route::post('/users',             [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit',  [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',       [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',    [UserController::class, 'destroy'])->name('users.destroy');
    });

// ─── Mahasiswa Routes ──────────────────────────────────────────────────────────
Route::prefix('mahasiswa')
    ->middleware(['auth', 'role:mahasiswa'])
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard',              [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/history',                [MahasiswaController::class, 'history'])->name('history');
        Route::get('/reports/create',         [MahasiswaController::class, 'create'])->name('reports.create');
        Route::post('/reports',               [MahasiswaController::class, 'store'])->name('reports.store');
        Route::get('/reports/{report}',       [MahasiswaController::class, 'show'])->name('reports.show');
        Route::get('/reports/{report}/edit',  [MahasiswaController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{report}',       [MahasiswaController::class, 'update'])->name('reports.update');
        Route::delete('/reports/{report}',    [MahasiswaController::class, 'destroy'])->name('reports.destroy');
    });

// ─── Petugas Routes ────────────────────────────────────────────────────────────
Route::prefix('petugas')
    ->middleware(['auth', 'role:petugas'])
    ->name('petugas.')
    ->group(function () {
        Route::get('/dashboard',                  [PetugasController::class, 'dashboard'])->name('dashboard');
        Route::get('/tasks',                      [PetugasController::class, 'tasks'])->name('tasks');
        Route::get('/tasks/{report}',             [PetugasController::class, 'show'])->name('tasks.show');
        Route::post('/tasks/{report}/complete',   [PetugasController::class, 'complete'])->name('tasks.complete');
        Route::get('/history',                    [PetugasController::class, 'history'])->name('history');
    });
