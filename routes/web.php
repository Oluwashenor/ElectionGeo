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

Route::post('/create-election', [ElectionController::class, 'create'])->middleware('auth');
Route::get('/map/{election_id}', [ElectionController::class, 'map'])->middleware('auth');
Route::post('/update-map', [ElectionController::class, 'updateMap'])->middleware('auth');
Route::get('/elections', [ElectionController::class, 'index'])->middleware('auth');
Route::get('/manage-election/{id}', [ElectionController::class, 'manage'])->middleware('auth');
Route::get('/delete-election/{id}', [ElectionController::class, 'delete'])->middleware('auth');
Route::get('/election-result/{id}', [ElectionController::class, 'result'])->middleware('auth');

Route::get('/voting', [VoteController::class, 'index'])->middleware('auth');
Route::post('/submit-vote', [VoteController::class, 'create'])->middleware('auth');

Route::post('/loginAction', [UsersController::class, 'login']);
Route::post('/registerAction', [UsersController::class, 'register']);
Route::post('/voterslogin', [UsersController::class, 'voterslogin']);
Route::get('/logout', [UsersController::class, 'logout']);
Route::get('/profile/{email}', [UsersController::class, 'profile'])->middleware('auth');
Route::post('/updateProfile', [UsersController::class, 'updateProfile'])->middleware('auth');

Route::post('/create-contestant', [ContestantController::class, 'create'])->middleware('auth');
Route::post('/edit-contestant', [ContestantController::class, 'edit'])->middleware('auth');
Route::get('/delete-contestant/{contestant_id}/{election_id}', [ContestantController::class, 'delete'])->middleware('auth');

Route::get('/register', function () {
    return view('register');
});

Route::get('/map', function () {
    return view('map');
})->middleware('auth');

Route::get('/login', function () {
    return view('login');
})->name('login');
