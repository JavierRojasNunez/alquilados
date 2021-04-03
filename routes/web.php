<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['verify' => true]);


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/confirmation', [App\Http\Controllers\HomeController::class, 'redirectRegister']);
//anuncios
//Route::get('/nuevo-anuncio', [App\Http\Controllers\AnuncioController::class, 'create'])->name('create.anounce');
Route::get('/nuevo-anuncio/{type?}', [App\Http\Controllers\AnuncioController::class, 'create'])->name('create.anounce')->middleware('verified');
Route::post('/publicar', [App\Http\Controllers\AnuncioController::class, 'save'])->name('save.anounce');
Route::get('/mis-anuncios', [App\Http\Controllers\AnuncioController::class, 'getAnounces'])->name('my.anounce');
Route::get('/editar-anuncio/{id}/{type?}', [App\Http\Controllers\AnuncioController::class, 'edit'])->name('edit.anounce');
Route::get('/eliminar-anuncio/{id}', [App\Http\Controllers\AnuncioController::class, 'delete'])->name('delete.anounce');
Route::get('/detalles/{anounce_id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail.anounce');

// imagenes de los anuncios
Route::get('/eliminar-imagenes/{id}/{anounce_id}', [App\Http\Controllers\ImagenController::class, 'deleteImage'])->name('delete.image');
Route::get('/editar-imagenes/{id}/{type?}', [App\Http\Controllers\ImagenController::class, 'editImages'])->name('edit.images');
Route::get('/anounces/{id?}/{filename?}',  [App\Http\Controllers\ImagenController::class, 'getImage'])->name('image.file');
Route::post('/guardar/imagenes', [App\Http\Controllers\ImagenController::class, 'saveImages'])->name('save.images');
//ciudades y provincias
Route::get('/cities/{city_id}', [App\Http\Controllers\CitiesController::class, 'getCities']);
Route::get('/adress/{char}/{province_id}', [App\Http\Controllers\CitiesController::class, 'getAdress']);

//consumo api
Route::get('/api-anuncios/{id?}', [App\Http\Controllers\GetApiDataController::class, 'getAll']);
Route::post('/create', [App\Http\Controllers\GetApiDataController::class, 'create']);
Route::get('/create', [App\Http\Controllers\GetApiDataController::class, 'create']);
