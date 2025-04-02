<?php

use App\Http\Middleware\EnsureIsAdmin;
use App\Livewire\Classroom;
use App\Livewire\StudentsView;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/students', StudentsView::class);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    EnsureIsAdmin::class,
])->group(function () {
    Route::get('/classroom', Classroom::class);
});
