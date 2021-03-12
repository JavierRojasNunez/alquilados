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


//Auth::routes();
Auth::routes(['verify' => true]);

/*Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!')->with('resent', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');*/


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/confirmation', [App\Http\Controllers\HomeController::class, 'redirectRegister']);
//anuncios
//Route::get('/nuevo-anuncio', [App\Http\Controllers\AnuncioController::class, 'create'])->name('create.anounce');
Route::get('/nuevo-anuncio', [App\Http\Controllers\AnuncioController::class, 'create'])->name('create.anounce')->middleware('verified');
Route::post('/publicar', [App\Http\Controllers\AnuncioController::class, 'save'])->name('save.anounce');
Route::get('/mis-anuncios', [App\Http\Controllers\AnuncioController::class, 'getAnounces'])->name('my.anounce');
Route::get('/editar-anuncio/{id}', [App\Http\Controllers\AnuncioController::class, 'edit'])->name('edit.anounce');
Route::get('/eliminar-anuncio/{id}', [App\Http\Controllers\AnuncioController::class, 'delete'])->name('delete.anounce');

// imagenes de los anuncios
Route::get('/eliminar-imagenes/{id}/{anounce_id}', [App\Http\Controllers\ImagenController::class, 'deleteImage'])->name('delete.image');
Route::get('/editar-imagenes/{id}', [App\Http\Controllers\ImagenController::class, 'editImages'])->name('edit.images');
Route::get('/anounces/{id?}/{filename?}',  [App\Http\Controllers\ImagenController::class, 'getImage'])->name('image.file');
Route::post('/guardar/imagenes', [App\Http\Controllers\ImagenController::class, 'saveImages'])->name('save.images');
//ciudades y provincias
Route::get('/cities/{city_id}', [App\Http\Controllers\CitiesController::class, 'getCities']);
Route::get('/adress/{char}/{province_id}', [App\Http\Controllers\CitiesController::class, 'getAdress']);
