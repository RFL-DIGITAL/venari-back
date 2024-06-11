<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

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

Route::middleware('auth:api')->group(function () {
    Route::get('user', [UserController::class, 'show'])->name('show');
    Route::get('user/posts', [PostController::class, 'getPostByUser'])->name('getPostByUser');
});

Route::get('company/{id}', [CompanyController::class, 'show'])->name('show');


Route::prefix('vacancies')->group(function () {
    Route::get('/{id}', [VacancyController::class, 'getVacancyByID'])->name('getVacancyByID');

    Route::get('', [VacancyController::class, 'getVacancies'])->name('getVacancies');
});

Route::middleware('auth:api')->prefix('messages')->group(function () {
    Route::get('{userID}', [MessageController::class, 'getMessagesByUserID'])
        ->name('getMessagesByUserID');
    Route::post('join-chat', [MessageController::class, 'joinChat'])->name('joinChat');
    Route::post('quit-chat', [MessageController::class, 'joinChat'])->name('joinChat');

    Route::get('', [MessageController::class, 'getChats'])->name('getChats');
});

Route::prefix('networking')->group(function () {
    Route::get('{chatID}/messages', [ChatController::class, 'getChatMessagesByChatID'])
        ->name('getChatMessagesByChatID');
    Route::get('{chatID}', [ChatController::class, 'getChatDetail'])
        ->name('getChatDetail');
    Route::get('', [ChatController::class, 'getAllChats'])
        ->name('getAllChats');
});

Route::prefix('messages')->group(function () {
    Route::post('send-message', [MessageController::class, 'sendMessage'])->name('sendMessage');
});

Route::prefix('posts')->group(function () {
    Route::get('{ID}/comments', [CommentController::class, 'getComments'])->name('getComments');
    Route::get('{ID}', [PostController::class, 'getPostByID'])->name('getPostByID');
    Route::get('', [PostController::class, 'getPosts'])->name('getPosts');
});

Route::prefix('comments')->group(function () {
    Route::post('send-comment', [CommentController::class, 'sendComment'])->name('sendComment');
});

// todo: Добавить crypter для шифрования персональных данных
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


