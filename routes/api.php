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
Route::get('/programDonasi/paginate', [ProgramDonasiController::class, 'getProgramDonasiPaginate']);
Route::get('/programDonasi/{id}', [ProgramDonasiController::class, 'getProgramDonasiById']);

Route::get('/artikel', [BeritaController::class, 'getArtikel']);
Route::get('/laporanProgramDonasiPDF', [ProgramDonasiController::class, 'LaporanProgramDonasiPDF'])->name('pdf.programdonasi');


// api untuk Program Relawan
Route::get('/programRelawan', [ProgramRelawanController::class, 'getProgramRelawan']);
Route::get('/programRelawan/{id}', [ProgramRelawanController::class, 'getProgramRelawanById']);


Route::get('/csrf-cookie', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::get('/laporanDonasiPDF', [DonasiController::class, 'LaporanDonasiPDF']);

Route::middleware('auth:sanctum')->group( function () {
    
    Route::get('/laporanProgramRelawanPDF', [ProgramRelawanController::class, 'LaporanProgramRelawanPDF']);
    Route::get('/laporanRelawanPDF', [RelawanController::class, 'LaporanRelawanPDF']);
    
    Route::group(['middleware' => ['level_user:1|2|3|4|5']], function () {
        Route::get('/donasi', [DonasiController::class, 'getDonasi']);
            Route::post('/donasi', [DonasiController::class, 'CreateDonasi']);
            
            
            Route::get('/relawan', [RelawanController::class, 'getRelawan']);
            Route::post('/relawan', [RelawanController::class, 'CreateRelawan']);
    }); 


    Route::group(['middleware' => ['level_user:1|2|3|4']], function () { 
        Route::resource('/post', PostController::class);
        
        // api untuk crud berita
        Route::post('/berita', [BeritaController::class, 'CreateBerita']);
        Route::patch('/berita/{id}', [BeritaController::class, 'UpdateBerita']);
        Route::delete('/berita/{id}', [BeritaController::class, 'deleteBerita']);
        
        // api untuk userAktif
        Route::get('/userAktif', [UserController::class, 'getUserAktif']);      
        Route::put('/userAktif/{id}', [UserController::class, 'updateUser']);
        Route::delete('/userAktif/{id}', [UserController::class, 'deleteUser']);
        
        // api get userMeninggal
        Route::get('/userMeninggal', [MeninggalController::class, 'getMeninggal']);
        Route::post('/userMeninggal', [MeninggalController::class, 'Createmeninggal']);
        Route::patch('/userMeninggal/{id}', [MeninggalController::class, 'updateMeninggal']);
        Route::delete('/userMeninggal/{id}', [MeninggalController::class, 'deleteMeninggal']);
        
        // Api untuk plafon beasiswa
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
    
    // api untuk level user Pengurus YST & DPP
    Route::group(['middleware' => ['level_user:1|2|3']], function () {
            
        Route::get('/laporan', [LaporanController::class, 'getLaporan']);
        Route::post('/laporan/pemasukan', [LaporanController::class, 'CreatePemasukan']);
        Route::post('/laporan/pengeluaran', [LaporanController::class, 'CreatePengeluaran']);
        Route::patch('/laporan/pemasukan/{id}', [LaporanController::class, 'updatePemasukan']);
        Route::patch('/laporan/pengeluaran/{id}', [LaporanController::class, 'updatePengeluaran']);
        Route::delete('/laporan/{id}', [LaporanController::class, 'deleteLaporan']);
        
        
        Route::patch('/programRelawan/approve/{id}', [ProgramRelawanController::class, 'approveProgramRelawan']);
        
        Route::patch('/beasiswa/reject/{id}', [BeasiswaController::class, 'rejectBeasiswa']);
            Route::patch('/beasiswa/approve/{id}', [BeasiswaController::class, 'approveBeasiswa']);
            
            
            Route::get('/kelolaKonten', [BerandaController::class, 'getBeranda']);
            Route::post('/kelolaKonten', [BerandaController::class, 'createOrUpdateBeranda']);
            
            Route::patch('/donasi/approve/{id}', [DonasiController::class, 'approveDonasi']);
            
            
            Route::get('/LaporanProgramRelawan', [ProgramRelawanController::class, 'laporanProgramRelawan']);
            Route::get('/LaporanRelawan', [RelawanController::class, 'getLaporanRelawan']);
            Route::get('/LaporanProgramDonasi', [ProgramDonasiController::class, 'getlaporanProgramDonasi']);
            Route::get('/LaporanDonasi', [DonasiController::class, 'getLaporanDonasi']);
            
        }); 
        // api untuk Pengurus DPW
        Route::group(['middleware' => ['level_user:1|2|3|4']], function () {
            
            Route::patch('/programDonasi/approve/{id}', [ProgramDonasiController::class, 'approveProgramDonasi']);
            Route::patch('/relawan/approve/{id}', [RelawanController::class, 'approveRelawan']);
            Route::patch('/relawan/reject/{id}', [RelawanController::class, 'rejectRelawan']);
            
            
        }); 
        
        
        Route::post('/logout', [RegisterController::class, 'logout']);
        
    });

            
    
    
    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        //     return $request->user();
// });
