<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/anuncios/{limit?}', [App\Http\Controllers\ApiController::class, 'getAll']);
Route::get('/v1/anuncio/{id?}', [App\Http\Controllers\ApiController::class, 'getOne']);
Route::get('/v1/titulos/{id?}', [App\Http\Controllers\ApiController::class, 'getTitle']);
Route::get('/v1/todo/{limit?}', [App\Http\Controllers\ApiController::class, 'getAllWithImages']);
Route::get('/v1/filtrado/{arga?}/{argb?}/{argc?}', [App\Http\Controllers\ApiController::class, 'getBy']);
