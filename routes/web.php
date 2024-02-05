<?php

use App\Http\Controllers\Admin\BukuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LemariController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Admin\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login/auth', 'authenticate')->name('auth');
    });

});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('bukus');
        Route::get('/buku/{buku}/detail', 'show')->name('detail-buku');
        Route::get('/buku/cari' , 'search')->name('cari-buku');
        Route::get('/buku/kategori/{kategori}', 'category')->name('kategori-buku');
    });

    Route::controller(LemariController::class)->group(function () {
        Route::post('/buku/{buku}/pinjam' , 'store')->name('pinjam-buku');
        Route::patch('/buku/{buku}/{peminjaman}/kembali ' , 'update')->name('kembalikan-buku');
    });
    
    Route::controller(UserProfileController::class)->group(function () {
        Route::get('/user/profile' , 'index')->name('profil-user');
        Route::get('/user/profile/edit' , 'edit')->name('profil-edit');
        Route::patch('/user/{user}/profile/simpam' , 'update')->name('simpan-profil');
    });
    
    Route::middleware('admin')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('admin-dashboard');
        });  
        Route::controller(BukuController::class)->group(function () {
            Route::get('/master/buku', 'index')->name('master-buku');
            Route::get('/master/buku/create', 'create')->name('master-buku-create');
            Route::get('/master/buku/{buku}/detail', 'show')->name('master-buku-detail');
            Route::delete('/master/buku/{buku}/delete', 'destroy')->name('master-buku-delete');
        });  
    });

});
