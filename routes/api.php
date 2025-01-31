<?php

use Illuminate\Http\Request;
use App\Http\Controllers\MasakanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/masakan', [MasakanController::class, 'index'])->name('api.masakan.index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
