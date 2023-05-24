<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ContestantController;
use Illuminate\Support\Facades\Route;
/*
| Web Routes
|------------
| Here is where you can register web routes for your application.
*/

Route::get('/', [UsersController::class, 'welcome']);

Route::post('/create-election', [ElectionController::class, 'create']);
Route::get('/map/{election_id}', [ElectionController::class, 'map']);
Route::post('/update-map', [ElectionController::class, 'updateMap']);
Route::get('/elections', [ElectionController::class, 'index']);
Route::get('/manage-election/{id}', [ElectionController::class, 'manage']);
Route::get('/delete-election/{id}', [ElectionController::class, 'delete']);
Route::get('/election-result/{id}', [ElectionController::class, 'result']);

Route::get('/voting', [VoteController::class, 'index']);
Route::post('/submit-vote', [VoteController::class, 'create']);

Route::post('/loginAction', [UsersController::class, 'login']);
Route::post('/registerAction', [UsersController::class, 'register']);
Route::post('/voterslogin', [UsersController::class, 'voterslogin']);
Route::get('/logout', [UsersController::class, 'logout']);
Route::get('/profile/{email}', [UsersController::class, 'profile']);
Route::post('/updateProfile', [UsersController::class, 'updateProfile']);

Route::post('/create-contestant', [ContestantController::class, 'create']);
Route::post('/edit-contestant', [ContestantController::class, 'edit']);
Route::get('/delete-contestant/{contestant_id}/{election_id}', [ContestantController::class, 'delete']);

Route::get('register', function () {
    return view('register');
});

Route::get('map', function () {
    return view('map');
});

Route::get('/login', function () {
    return view('login');
});
