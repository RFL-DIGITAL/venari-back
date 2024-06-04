<?php

use App\Http\Controllers\VacanciesController;
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

Route::get('swag.json', function () {
    $p = @\OpenApi\Generator::scan([app_path()]);
    return response()->json($p->toJson());
});
