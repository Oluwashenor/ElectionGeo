<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ContestantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/elections', [ElectionController::class, 'index']);
Route::get('/voters', [VoteController::class, 'index']);
Route::post('/submit-vote', [VoteController::class, 'create']);
Route::get('adminlogin', function () {
    return view('adminlogin');
});

Route::get('login', function () {
    return view('login');
});

Route::post('/loginAction', [UsersController::class, 'login']);
Route::post('/registerAction', [UsersController::class, 'register']);
Route::post('/voterslogin', [VoteController::class, 'voterslogin']);
Route::get('/logout', [UsersController::class, 'logout']);
Route::post('/create-election', [ElectionController::class, 'create']);


Route::post('/create-contestant', [ContestantController::class, 'create']);
Route::get('/delete-contestant/{contestant_id}/{election_id}', [ContestantController::class, 'delete']);
Route::get('/manage-election/{id}', [ElectionController::class, 'manage']);

Route::get('register', function () {
    return view('register');
});

Route::get('map', function () {
    return view('map');
});
