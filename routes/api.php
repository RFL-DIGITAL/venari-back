<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/vacancies', [VacancyController::class, 'getVacancies'])->name('getVacancies');

Route::get('/posts/{post_id}', [PostController::class, 'getPostByID'])->name('getPostByID');
Route::get('/posts', [PostController::class, 'getPosts'])->name('getPosts');

// todo: Добавить crypter для шифрования персональных данных
Route::post('register', [UserController::class, 'register']);


