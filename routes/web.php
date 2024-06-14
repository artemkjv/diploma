<?php

use App\Http\Controllers\ClientRequestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SponsorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return to_route('dashboard');
});

Route::get('/new', function () {
    return \inertia('New');
})->name('new');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['not.new'])->group(function () {
        Route::resource('projects', ProjectController::class)->except(['update', 'show']);
        Route::post('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');

        Route::resource('events', EventController::class)->except(['update', 'show']);
        Route::post('/events/{id}', [EventController::class, 'update'])->name('events.update');

        Route::resource('news', NewsController::class)->except(['update', 'show']);
        Route::post('/news/{id}', [NewsController::class, 'update'])->name('news.update');

        Route::resource('sponsors', SponsorController::class)->except(['update', 'show']);
        Route::post('/sponsors/{id}', [SponsorController::class, 'update'])->name('sponsors.update');

        Route::resource('/client-requests', ClientRequestController::class)->except(['update', 'edit', 'create', 'store']);
        Route::patch('/client-requests/{id}/status', [ClientRequestController::class, 'updateStatus'])->name('client-requests.update-status');

        Route::resource('/users',\App\Http\Controllers\UserController::class)
            ->middleware('admin')
            ->except(['create', 'store', 'show']);
    });
});

Route::get('/guest/news', [\App\Http\Controllers\Guest\NewsController::class, 'index'])->name('guest.news.index');
Route::get('/guest/news/{id}', [\App\Http\Controllers\Guest\NewsController::class, 'show'])->name('guest.news.show');

require __DIR__ . '/auth.php';
