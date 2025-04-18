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
    Route::get('/grades', \App\Livewire\Grade::class)->name('grades');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    EnsureIsAdmin::class,
])->group(function () {
    Route::get('/classroom', Classroom::class)->name('classroom');
    Route::get('/students', StudentsView::class)->name('students');
    Route::get('/assign-subject', \App\Livewire\AssignSubject::class)->name('assign-subject');
    Route::get('/assignmentview', \App\Livewire\Assignmentview::class)->name('assignmentview');
});
