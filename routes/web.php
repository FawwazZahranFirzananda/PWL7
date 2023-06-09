<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ArticleController;
use App\Models\Article;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::resource('mahasiswas', MahasiswaController::class);
Route::get('/search',[MahasiswaController::class, 'search']);
Route::get('mahasiswas/nilai/{Nim}', [MahasiswaController::class, 'nilai'])->name('mahasiswas.nilai');
Route::resource('articles', ArticleController::class);
Route::get('/', [PageController::class, 'index']);
Route::get('/article/cetak_pdf', [ArticleController::class, 'cetak_pdf']);
Route::get('mahasiswa/{mahasiswa}/cetak_khs', [MahasiswaController::class, 'cetak_khs'])->name('mahasiswa.cetak_khs');