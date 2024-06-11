<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MessageController;
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

Route::prefix('vacancies')->group(function () {
    Route::get('/{id}', [VacancyController::class, 'getVacancyByID'])->name('getVacancyByID');

    Route::get('', [VacancyController::class, 'getVacancies'])->name('getVacancies');
});

Route::middleware('auth:api')->prefix('messages')->group(function () {
    Route::post('send-message', [MessageController::class, 'sendMessage'])->name('sendMessage');
    Route::get('{user_id}', [MessageController::class, 'getMessagesByUserID'])
        ->name('getMessagesByUserID');
    Route::get('/companies/{company_chat_id}', [MessageController::class, 'getCompanyMessagesByCompanyChatID'])
        ->name('getCompanyChatsByCompanyChatID');
    Route::post('join-chat', [MessageController::class, 'joinChat'])->name('joinChat');
    Route::post('quit-chat', [MessageController::class, 'quitChat'])->name('quitChat');

    Route::get('', [MessageController::class, 'getChats'])->name('getChats');
});

Route::prefix('networking')->group(function () {
    Route::get('{chat_id}/messages', [ChatController::class, 'getChatMessagesByChatID'])
        ->name('getChatMessagesByChatID');
    Route::get('{chat_id}', [ChatController::class, 'getChatDetail'])
        ->name('getChatDetail');
    Route::get('', [ChatController::class, 'getAllChats'])
        ->name('getAllChats');
});

Route::prefix('posts')->group(function () {
    Route::get('{id}/comments', [CommentController::class, 'getComments'])->name('getComments');
    Route::get('{id}', [PostController::class, 'getPostByID'])->name('getPostByID');
    Route::get('', [PostController::class, 'getPosts'])->name('getPosts');
});

Route::prefix('comments')->group(function () {
    Route::post('send-comment', [CommentController::class, 'sendComment'])->name('sendComment');
});

Route::get('/images/{id}', [ImageController::class, 'getImageByID'])->name('getImageByID');
Route::get('/files/{id}', [FileController::class, 'getFileByID'])->name('getFileByID');

// todo: Добавить crypter для шифрования персональных данных
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


