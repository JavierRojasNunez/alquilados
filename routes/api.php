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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/v1/create', [App\Http\Controllers\ApiController::class, 'create']);
Route::get('/v1/todo/{limit?}', [App\Http\Controllers\ApiController::class, 'getResumeWithImages']);
Route::delete('/v1/anuncio/{id}', [App\Http\Controllers\ApiController::class, 'delete']);
Route::put('/v1/edit/{id}', [App\Http\Controllers\ApiController::class, 'update']);
Route::get('/v1/anuncios/{limit?}', [App\Http\Controllers\ApiController::class, 'getAll']);
Route::get('/v1/anuncio/{id}', [App\Http\Controllers\ApiController::class, 'getOne']);
Route::get('/v1/titulos/{id?}', [App\Http\Controllers\ApiController::class, 'getTitle']);
Route::get('/v1/filter/{arga?}/{argb?}/{argc?}', [App\Http\Controllers\ApiController::class, 'getBy']);


Route::group(['prefix' => 'v1/auth'], function () {
    Route::post('login',  [App\Http\Controllers\AuthApiController::class, 'login']);
    Route::post('signup', [App\Http\Controllers\AuthApiController::class, 'signup']);
    
    
    // Las siguientes rutas además del prefijo requieren que el usuario tenga un token válido
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', [App\Http\Controllers\AuthApiController::class, 'logout']);
        Route::get('user', [App\Http\Controllers\AuthApiController::class, 'user']);
        
        //api
        Route::get('todo/{limit?}', [App\Http\Controllers\ApiController::class, 'getAllWithImages']);
        Route::post('create', [App\Http\Controllers\ApiController::class, 'create']);
        Route::delete('anuncio/{id}', [App\Http\Controllers\ApiController::class, 'delete']);
        Route::put('edit/{id}', [App\Http\Controllers\ApiController::class, 'update']);
        Route::get('anuncios/{limit?}', [App\Http\Controllers\ApiController::class, 'getAll']);
        Route::get('anuncio/{id?}', [App\Http\Controllers\ApiController::class, 'getOne']);
        Route::get('titulos/{id?}', [App\Http\Controllers\ApiController::class, 'getTitle']);
        Route::get('filter/{arga?}/{argb?}/{argc?}', [App\Http\Controllers\ApiController::class, 'getBy']);
    });
});