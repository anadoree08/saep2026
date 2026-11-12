<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/principal', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');
    Route::post('/tutores', [TutorController::class, 'store'])->name('tutores.store');
    Route::get('/tutores/{tutor}/editar', [TutorController::class, 'edit'])->name('tutores.edit');
    Route::put('/tutores/{tutor}', [TutorController::class, 'update'])->name('tutores.update');
    Route::delete('/tutores/{tutor}', [TutorController::class, 'destroy'])->name('tutores.destroy');

    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

    Route::get('/agendamentos', [AgendamentoController::class, 'index'])->name('agendamentos.index');
    Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamentos.store');
    Route::patch('/agendamentos/{agendamento}/data', [AgendamentoController::class, 'updateData'])->name('agendamentos.updateData');
});