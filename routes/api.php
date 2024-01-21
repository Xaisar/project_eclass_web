<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\KelasSiswa;
use App\Http\Controllers\Api\KelasSiswaDetail;

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

// Route untuk login
Route::post('/login', [LoginController::class, 'login']);

Route::post('/student/classes2', [KelasSiswa::class, 'index2']);
Route::post('/student/classes2/detailCourse', [KelasSiswa::class, 'detailCourse']);
Route::post('/student/Profil', [KelasSiswa::class, 'getProfil']);
Route::post('/student/classes2/kehadiran', [KelasSiswa::class, 'postKehadiran']);
Route::post('/student/classes2/tugasPengetahuan/upload', [KelasSiswa::class, 'postTugasKnowledge']);
Route::post('/student/classes2/tugasKeterampilan/upload', [KelasSiswa::class, 'postTugasSkill']);
Route::post('/student/Notifikasi', [KelasSiswa::class, 'getNotifikasi']);
Route::post('/student/GantiPassword', [KelasSiswa::class, 'postGantiPassword']);
Route::post('/student/GantiProfile', [KelasSiswa::class, 'postGantiProfile']);

// Middleware 'auth:sanctum' digunakan untuk memastikan hanya pengguna yang sudah login yang dapat mengakses route berikutnya
Route::middleware(['auth:sanctum'])->group(function () {

    // Route untuk mendapatkan daftar kelas siswa setelah login
    Route::get('/student/classes', [KelasSiswa::class, 'index']);

    // Route untuk logout jika diperlukan
    // Route::post('/logout', [LoginController::class, 'logout']);

    // Tambahkan rute untuk KelasSiswaDetail jika belum ada
    Route::get('/student/classes/{course}', [KelasSiswaDetail::class, 'detail']);
    Route::get('/student/classes/{course}/assignments', [KelasSiswaDetail::class, 'assignments']);
    Route::post('/student/classes/{course}/attendance', [KelasSiswaDetail::class, 'attendance']);
});
