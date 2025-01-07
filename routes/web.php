<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/meetings', [MeetingController::class, 'index']);
Route::post('/meetings', [MeetingController::class, 'store']);
Route::post('/meetings/{id}', [MeetingController::class, 'update']);
Route::delete('/meetings/{id}', [MeetingController::class, 'delete']);
Route::get('/meetings/statistics', [MeetingController::class, 'statistics']);

// Synchronize meetings with the antmedia server
Route::post('/meetings/sync/antmedia', [MeetingController::class, 'synchronize']);




// To handle 404 error in some routes 
Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');