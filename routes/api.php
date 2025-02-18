<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// All Graph Related DATA
Route::get('/crime-stats', [ChartController::class, 'crimeStats'])->name('crimeStats');
Route::get('/crime-counts', [ChartController::class, 'crimeCounts'])->name('crimeCounts');
Route::get('/crime-over-months', [ChartController::class, 'crimeOverMonths'])->name('crimeOverMonths');

// All Map Related DATA
Route::get('/crimes', [MapController::class, 'getCrimeData']);
