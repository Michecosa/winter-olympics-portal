<?php

use App\Http\Controllers\Api\AthleteController;
use App\Http\Controllers\Api\DisciplineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/* 
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

# http://127.0.0.1:8000/api/disciplines
Route::get('disciplines', [DisciplineController::class, 'index']);
Route::get('disciplines/{discipline}', [DisciplineController::class, 'show']);

# http://127.0.0.1:8000/api/athletes
Route::get('athletes', [AthleteController::class, 'index']);
Route::get('athletes/{athlete}', [AthleteController::class, 'show']);