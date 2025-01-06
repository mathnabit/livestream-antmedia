<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/meetings', [MeetingController::class, 'index']);
Route::post('/meetings', [MeetingController::class, 'store']);
Route::get('/meetings/{id}', [MeetingController::class, 'show']);
Route::post('/meetings/{id}', [MeetingController::class, 'update']);



// To handle 404 error in some routes 
Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');