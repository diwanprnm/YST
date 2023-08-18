<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::get('/get-wilayahs', [WilayahController::class, 'getWilayahs']);

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

// api untuk berita
Route::get('/berita', [BeritaController::class, 'getBerita']);
Route::get('/berita/{id}', [BeritaController::class, 'getBeritaById']);

// api untuk Kegiatan
Route::get('/kegiatan', [BeritaController::class, 'getKegiatan']);
Route::get('/kegiatan/{id}', [BeritaController::class, 'getKegiatanById']);

// api untuk Program Donasi
Route::get('/programDonasi', [ProgramDonasiController::class, 'getProgramDonasi']);
Route::get('/programDonasi/{id}', [ProgramDonasiController::class, 'getProgramDonasiById']);


// api untuk Program Relawan
Route::get('/programRelawan', [ProgramRelawanController::class, 'getProgramRelawan']);
Route::get('/programRelawan/{id}', [ProgramRelawanController::class, 'getProgramRelawanById']);


Route::middleware('auth:sanctum')->group( function () {
    //api post
    
    Route::post('/logout', [RegisterController::class, 'logout']);
    Route::resource('/post', PostController::class);
    // api untuk get wilayah
    
    // api untuk crud berita
    Route::post('/berita', [BeritaController::class, 'CreateBerita']);
    Route::patch('/berita/{id}', [BeritaController::class, 'UpdateBerita']);
    Route::delete('/berita/{id}', [BeritaController::class, 'deleteBerita']);
    
    // api untuk userAktif
    Route::get('/userAktif', [UserController::class, 'getUserAktif']);
    Route::put('/userAktif/{id}', [UserController::class, 'updateUser']);
    Route::delete('/userAktif/{id}', [UserController::class, 'deleteUser']);
    
    // 
    Route::get('/userMeninggal', [MeninggalController::class, 'getMeninggal']);
    Route::post('/userMeninggal', [MeninggalController::class, 'Createmeninggal']);
    Route::patch('/userMeninggal/{id}', [MeninggalController::class, 'updateMeninggal']);
    Route::delete('/userMeninggal/{id}', [MeninggalController::class, 'deleteMeninggal']);
    
    
    Route::get('/plafonBeasiswa', [PlafonBeasiswaController::class, 'getPlafonBeasiswa']);
    Route::patch('/plafonBeasiswa/{id}', [PlafonBeasiswaController::class, 'updatePlafonBeasiswa']);
    
    
    Route::get('/kategoriDonasi', [KategoriDonasiController::class, 'getkategoriDonasi']);
    Route::post('/kategoriDonasi', [KategoriDonasiController::class, 'CreateKategoriDonasi']);
    Route::patch('/kategoriDonasi/{id}', [KategoriDonasiController::class, 'updatekategoriDonasi']);
    Route::delete('/kategoriDonasi/{id}', [KategoriDonasiController::class, 'deleteDonasi']);
    
    
    Route::get('/kategoriRelawan', [KategoriRelawanController::class, 'getkategoriRelawan']);
    Route::post('/kategoriRelawan', [KategoriRelawanController::class, 'CreateKategoriRelawan']);
    Route::patch('/kategoriRelawan/{id}', [KategoriRelawanController::class, 'updatekategoriRelawan']);
    Route::delete('/kategoriRelawan/{id}', [KategoriRelawanController::class, 'deleteKategoriRelawan']);
    
    
    Route::get('/beasiswa', [BeasiswaController::class, 'getBeasiswa']);
    Route::post('/beasiswa', [BeasiswaController::class, 'CreateBeasiswa']);
    Route::patch('/beasiswa/{id}', [BeasiswaController::class, 'updateBeasiswa']);
    Route::delete('/beasiswa/{id}', [BeasiswaController::class, 'deleteBeasiswa']);
    

    Route::post('/programDonasi', [ProgramDonasiController::class, 'createProgramDonasi']);
    Route::patch('/programDonasi/{id}', [ProgramDonasiController::class, 'updateProgramDonasi']);
    Route::delete('/programDonasi/{id}', [ProgramDonasiController::class, 'deleteProgramDonasi']);
    
    
    Route::post('/programRelawan', [ProgramRelawanController::class, 'createProgramRelawan']);
    Route::patch('/programRelawan/{id}', [ProgramRelawanController::class, 'updateProgramRelawan']);
    Route::delete('/programRelawan/{id}', [ProgramRelawanController::class, 'deleteProgramRelawan']);
});




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
