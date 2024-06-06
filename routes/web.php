<?php

use App\Http\Controllers\ChatController;
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

Route::get('swagger', function () {
    return view('swagger');
});

Route::get('/chats/{myID}', [ChatController::class, 'getChats'])->name('getChats');

Route::get('/chats/personal/{userID}', [ChatController::class, 'getMessagesByUserID'])
    ->name('getMessagesByUserID');
Route::get('/chats/group/{chatID}', [ChatController::class, 'getChatMessagesByChatID'])
    ->name('getChatMessagesByChatID');

Route::get('swag.json', function () {
    $p = @\OpenApi\Generator::scan([app_path()]);
    return response()->json($p->toJson());
});
