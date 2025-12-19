<?php

use App\Http\Controllers\ResidentController;
use Illuminate\Support\Facades\Route;
// use Laravel\Fortify\Features;
// use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('layouts.app');
})->name('home');
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('/resident', [ResidentController::class, 'index']);
Route::get('/resident/create', [ResidentController::class, 'create']);
Route::get('/resident/{id}', [ResidentController::class, 'edit']);
Route::post('/resident', [ResidentController::class, 'store']);
Route::put('/resident/{id}', [ResidentController::class, 'update']);
Route::delete('/resident/{id}', [ResidentController::class, 'delete']);

