<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ApplicationController;

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

Route::prefix('users')->group(function () {
    Route::get('{id}/posts', [PostController::class, 'getPostsByUser'])->name('getPostsByUser');
    Route::get('{id}', [UserController::class, 'show'])->name('user');
});

Route::middleware('auth:api')->get('/user', function () {
    return request()->user();
});

Route::prefix('companies')->group(function () {
    Route::get('{id}/posts', [PostController::class, 'getPostsByCompany'])->name('getPostsByCompany');
    Route::get('{id}', [CompanyController::class, 'show'])->name('company');
});

Route::prefix('vacancies')->group(function () {
    Route::get('/{id}', [VacancyController::class, 'getVacancyByID'])->name('getVacancyByID');
    Route::post('apply', [ApplicationController::class, 'apply'])->name('apply')
        ->middleware('auth:api');

    Route::get('', [VacancyController::class, 'getVacancies'])->name('getVacancies');
});

Route::prefix('notifications')->middleware('auth:api')->group(function () {
    Route::get('', [NotificationController::class, 'getNotifications'])->name('getNotifications');
    Route::post('read', [NotificationController::class, 'readNotifications'])->name('readNotifications');
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
    Route::get('{id}/comments', [PostController::class, 'getComments'])->name('getComments');
    Route::get('{id}', [PostController::class, 'getPostByID'])->name('getPostByID');
    Route::get('', [PostController::class, 'getPosts'])->name('getPosts');
});

Route::prefix('comments')->middleware('auth:api')->group(function () {
    Route::post('send-comment', [CommentController::class, 'sendComment'])->name('sendComment');
});

Route::get('/images/{id}', [ImageController::class, 'getImageByID'])->name('getImageByID');
Route::get('/files/{id}', [FileController::class, 'getFileByID'])->name('getFileByID');

// todo: Добавить crypter для шифрования персональных данных
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::prefix('variants')->group(function () {
   Route::get('see-variants/{code}', [ApplicationController::class, 'getApplicationsByGroupCode'])
       ->name('getApplicationsByGroupCode');
   Route::post('send-approve', [ApplicationController::class, 'sendApprove'])->name('sendApprove');
});

Route::prefix('resumes')->group(function () {
    Route::get('{id}', [ResumeController::class, 'getResumeByID'])->name('getResumeByID');
    Route::post('create-resume', [ResumeController::class, 'createResume'])->name('createResume')->middleware('auth:api');
    Route::post('edit-resume', [ResumeController::class, 'editResume'])->name('editResume')->middleware('auth:api');;
    Route::post('create-from-file', [ResumeController::class, 'createResumeFromDoc'])
        ->name('createResumeFromDoc')->middleware('auth:api');
});

Route::get('resume-filters', [FilterController::class, 'getFiltersForResumeCreation'])->name('getFiltersForResumeCreation');

Route::middleware('auth:api')->prefix('hr-panel')->group(function () {
    Route::prefix('vacancies')->group(function () {
        Route::post('create-vacancy', [VacancyController::class, 'createVacancy'])->name('createVacancy');
        Route::post('edit-vacancy', [VacancyController::class, 'editVacancy'])->name('editVacancy');
        Route::post('archive-vacancies', [VacancyController::class, 'archiveVacancies'])
            ->name('archiveVacancies');
        Route::post('un-archive-vacancies', [VacancyController::class, 'unArchiveVacancies'])
            ->name('unArchiveVacancies');
        Route::get('', [VacancyController::class, 'getVacanciesHR'])->name('getVacanciesHR');
    });

    Route::prefix('calendar')->group(function () {
        Route::post('login-with-google', [CalendarController::class, 'loginWithGoogle'])
            ->name('loginWithGoogle');
        Route::post('create-slots', [CalendarController::class, 'createSlots'])->name('createSlots');
        Route::get('get-calendar-id', [CalendarController::class, 'getCalendarID'])->name('getCalendarID');
        Route::post('get-available-slots', [CalendarController::class, 'getAvailableSlotsInMonth'])->name('getAvailableSlotsInMonth');
        Route::post('book-event', [CalendarController::class, 'bookSlot'])->name('bookSlot');
        Route::get('download-ics', [CalendarController::class, 'downloadICS'])->name('downloadIcs');
    });

    Route::get('filters', [FilterController::class, 'getAllFilters'])->name('getAllFilters');

    Route::prefix('candidates')->group(function () {
        Route::post('change-stages', [ApplicationController::class, 'changeStage']);
        Route::get('stages', [StageController::class, 'getStages']);
        Route::get('applications', [ApplicationController::class, 'getApplication']);
        Route::post('share-applications', [ApplicationController::class, 'shareApplications']);
        Route::get('applications/{id}', [ApplicationController::class, 'getApplicationByID']);
        Route::get('', [ApplicationController::class, 'getUsers']);
    });
});
