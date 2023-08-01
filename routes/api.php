<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;

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

//api post
Route::resource('/post', PostController::class);

// api untuk get wilayah
Route::get('/get-wilayahs', [WilayahController::class, 'getWilayahs']);

// api untuk crud berita
Route::get('/berita', [BeritaController::class, 'getBerita']);
Route::post('/berita', [BeritaController::class, 'CreateBerita']);
Route::put('/berita/{id}', [BeritaController::class, 'UpdateBerita']);
Route::delete('/berita/{id}', [BeritaController::class, 'deleteBerita']);









Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
