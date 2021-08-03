<?php

use Illuminate\Support\Facades\Route;

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

//rutas para la verificacion de email si fuese solo API
//Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\VerificationController::class, 'verify'])->name('verification.verify');  
//Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/confirmation', [App\Http\Controllers\HomeController::class, 'redirectRegister']);
Route::get('/weather/{lat}/{lon}', [App\Http\Controllers\WeatherController::class, 'getWeather']);
Route::post('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search.get');

//anuncios
//Route::get('/nuevo-anuncio', [App\Http\Controllers\AnuncioController::class, 'create'])->name('create.anounce');
Route::get('/nuevo-anuncio/{type?}', [App\Http\Controllers\AnuncioController::class, 'create'])->name('create.anounce')->middleware(['auth', 'verified']);
Route::post('/publicar', [App\Http\Controllers\saveAdController::class, 'save'])->name('save.anounce')->middleware(['auth', 'verified']);
Route::get('/mis-anuncios', [App\Http\Controllers\AnuncioController::class, 'getAnounces'])->name('my.anounce')->middleware(['auth', 'verified']);
Route::get('/editar/anuncio/{id}/{type}', [App\Http\Controllers\AnuncioController::class, 'edit'])->name('edit.anounce')->middleware(['auth', 'verified']);
Route::get('/eliminar-anuncio/{id}', [App\Http\Controllers\AnuncioController::class, 'delete'])->name('delete.anounce')->middleware(['auth', 'verified']);
Route::get('/detalles/{anounce}', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail.anounce');

// imagenes de los anuncios
Route::get('/eliminar-imagenes/{id}/{anounce_id}', [App\Http\Controllers\ImagenController::class, 'deleteImage'])->name('delete.image')->middleware(['auth', 'verified']);
Route::get('/editar-imagenes/{id}/{type?}', [App\Http\Controllers\ImagenController::class, 'editImages'])->name('edit.images')->middleware(['auth', 'verified']);
Route::get('/images/{id}/{filename}',  [App\Http\Controllers\ImagenController::class, 'getImage'])->name('image.file');
Route::post('/guardar/imagenes', [App\Http\Controllers\ImagenController::class, 'saveImages'])->name('save.images')->middleware(['auth', 'verified']);
//ciudades y provincias
Route::get('/cities/{city_id}', [App\Http\Controllers\CitiesController::class, 'getCities']);
Route::get('/adress/{char}/{province_id}', [App\Http\Controllers\CitiesController::class, 'getAdress']);

//export excel
Route::get('/export/users', [App\Http\Controllers\ExcelController::class, 'UserExport']);

//Import excel
Route::get('/import/products', [App\Http\Controllers\ExcelController::class, 'productImport']);
//consumo api
Route::get('/api-anuncios/{id?}', [App\Http\Controllers\GetApiDataController::class, 'getAll'])->middleware(['auth', 'verified']);

//rutas vue
Route::post('/producto', [App\Http\Controllers\ProductController::class, 'store'])->middleware(['auth', 'verified']);

Route::get('/producto/{product_id}', [App\Http\Controllers\ProductController::class, 'show'])->middleware(['auth', 'verified']);
Route::delete('/eliminar-producto/{product_id}', [App\Http\Controllers\ProductController::class, 'delete'])->middleware(['auth', 'verified']);
Route::get('/todos-productos', [App\Http\Controllers\ProductController::class, 'all'])->middleware(['auth', 'verified']);
Route::put('/actualizar-producto/{product_id}', [App\Http\Controllers\ProductController::class, 'update'])->middleware(['auth', 'verified']);

//rutas perfil user

Route::get('/mi-perfil', [App\Http\Controllers\UserController::class, 'get'])->name('profile')->middleware(['auth', 'verified']);
Route::resource('/perfil', App\Http\Controllers\UserController::class)->middleware(['auth', 'verified']);

Route::group(['prefix' => 'admin'], function () {
   // Voyager::routes();
});

//chats 
Route::get('/chat',      [App\Http\Controllers\ChatsController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/messages',  [App\Http\Controllers\ChatsController::class, 'fetchMessages'])->middleware(['auth', 'verified']);
Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage'])->middleware(['auth', 'verified']);