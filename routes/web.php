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

//rutas para la verificacion de email si fuese solo API
//Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\VerificationController::class, 'verify'])->name('verification.verify');  
//Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/confirmation', [App\Http\Controllers\HomeController::class, 'redirectRegister']);
Route::get('/weather/{lat}/{lon}', [App\Http\Controllers\WeatherController::class, 'getWeather']);
Route::post('/search', [App\Http\Controllers\SearchController::class, 'search']);
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search']);

//anuncios
//Route::get('/nuevo-anuncio', [App\Http\Controllers\AnuncioController::class, 'create'])->name('create.anounce');
Route::get('/nuevo-anuncio/{type?}', [App\Http\Controllers\AnuncioController::class, 'create'])->name('create.anounce')->middleware(['auth', 'verified' ]);
Route::post('/publicar', [App\Http\Controllers\saveAdController::class, 'save'])->name('save.anounce')->middleware(['auth', 'verified' ]);
Route::get('/mis-anuncios', [App\Http\Controllers\AnuncioController::class, 'getAnounces'])->name('my.anounce')->middleware(['auth', 'verified' ]);
Route::get('/editar/anuncio/{id}/{type}', [App\Http\Controllers\AnuncioController::class, 'edit'])->name('edit.anounce')->middleware(['auth', 'verified' ]);
Route::get('/eliminar-anuncio/{id}', [App\Http\Controllers\AnuncioController::class, 'delete'])->name('delete.anounce')->middleware(['auth', 'verified' ]);
Route::get('/detalles/{anounce}', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail.anounce');

// imagenes de los anuncios
Route::get('/eliminar-imagenes/{id}/{anounce_id}', [App\Http\Controllers\ImagenController::class, 'deleteImage'])->name('delete.image')->middleware(['auth', 'verified']);
Route::get('/editar-imagenes/{id}/{type?}', [App\Http\Controllers\ImagenController::class, 'editImages'])->name('edit.images')->middleware(['auth', 'verified']);
Route::get('/images/{id}/{filename}',  [App\Http\Controllers\ImagenController::class, 'getImage'])->name('image.file');
Route::post('/guardar/imagenes', [App\Http\Controllers\ImagenController::class, 'saveImages'])->name('save.images')->middleware(['auth', 'verified']);
//ciudades y provincias
Route::get('/cities/{city_id}', [App\Http\Controllers\CitiesController::class, 'getCities']);
Route::get('/adress/{char}/{province_id}', [App\Http\Controllers\CitiesController::class, 'getAdress']);

//consumo api
Route::get('/api-anuncios/{id?}', [App\Http\Controllers\GetApiDataController::class, 'getAll'])->middleware(['auth', 'verified']);


