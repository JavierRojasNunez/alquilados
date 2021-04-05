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

Route::post('/v1/create/{id?}', [App\Http\Controllers\ApiController::class, 'create']);
Route::get('/v1/resume/{limit?}/{id?}', [App\Http\Controllers\ApiController::class, 'getResumeWithImages']);
Route::delete('/v1/eliminar-anuncio/{id}', [App\Http\Controllers\ApiController::class, 'delete']);
Route::put('/v1/edit/{id}', [App\Http\Controllers\ApiController::class, 'update']);
Route::get('/v1/anuncios', [App\Http\Controllers\ApiController::class, 'getAll']);
Route::get('/v1/anuncio/{id?}', [App\Http\Controllers\ApiController::class, 'getOne']);
Route::get('/v1/basics/{id?}', [App\Http\Controllers\ApiController::class, 'getBasics']);
Route::get('/v1/by/{arga}/{argb?}/{argc?}', [App\Http\Controllers\ApiController::class, 'getBy']);


Route::group(['prefix' => 'v1/auth'], function () {
    Route::post('login',  [App\Http\Controllers\AuthApiController::class, 'login']);
    Route::post('signup', [App\Http\Controllers\AuthApiController::class, 'signup']);
    
    

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', [App\Http\Controllers\AuthApiController::class, 'logout']);
        Route::get('user', [App\Http\Controllers\AuthApiController::class, 'user']);
        
        Route::get('resume/{limit?}/{id?}', [App\Http\Controllers\ApiController::class, 'getResumeWithImages']);//metodo completo
        Route::post('create/{id?}', [App\Http\Controllers\ApiController::class, 'create']);
        Route::post('update/{id?}', [App\Http\Controllers\ApiController::class, 'create']);
        Route::delete('eliminar-anuncio/{id}', [App\Http\Controllers\ApiController::class, 'delete']);        
        Route::get('anuncios', [App\Http\Controllers\ApiController::class, 'getAll']);//metodo completo
        Route::get('anuncio/{id?}', [App\Http\Controllers\ApiController::class, 'getOne']);//metodo completo
        Route::get('basics/{id?}', [App\Http\Controllers\ApiController::class, 'getBasics']);//acabado muestra todos con titulo y descripcion y provincia
        Route::get('by/{arga}/{argb?}/{argc?}', [App\Http\Controllers\ApiController::class, 'getBy']);
    });
});