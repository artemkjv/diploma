<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['as' => 'api.grapejs.'], function () {
    Route::post('/grapejs/{id}', [\App\Http\Controllers\Api\GrapeJsController::class, 'store'])->name('store');
    Route::get('/grapejs/{id}', [\App\Http\Controllers\Api\GrapeJsController::class, 'load'])->name('load');
});

Route::post('/client-requests', [\App\Http\Controllers\Api\ClientRequestController::class, 'store'])->name('api.client-requests.store');
Route::get('/news', [\App\Http\Controllers\Api\NewsController::class, 'index'])->name('api.news.index');
Route::get('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'show'])->name('api.news.show');
