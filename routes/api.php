<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ChatController;
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

Route::prefix('chats')->group(function () {
    Route::get('personal/{userID}', [ChatController::class, 'getMessagesByUserID'])
        ->name('getMessagesByUserID');
    Route::get('group/{chatID}', [ChatController::class, 'getChatMessagesByChatID'])
        ->name('getChatMessagesByChatID');

    Route::get('', [ChatController::class, 'getChats'])->name('getChats');
});

Route::prefix('messages')->group(function () {
    Route::post('send-message', [MessageController::class, 'sendMessage'])->name('sendMessage');
});

Route::prefix('posts')->group(function () {
    Route::get('{ID}', [PostController::class, 'getPostByID'])->name('getPostByID');
    Route::get('', [PostController::class, 'getPosts'])->name('getPosts');
});


// todo: Добавить crypter для шифрования персональных данных
Route::post('register', [UserController::class, 'register']);


