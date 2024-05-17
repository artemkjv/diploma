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
