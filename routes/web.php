<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthCustomController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\ArtikelController as AdminArtikelController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\GoogleController;

// Route::get('/', function () {
//     return view('landing');
// })->name('landing');

Route::get('/auth', function () {
    return view('auth.index');
});

Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback',  [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/login', [AuthCustomController::class, 'index'])->name('login');
Route::post('/login', [AuthCustomController::class, 'login'])->name('auth.login.post');

Route::get('/register', [AuthCustomController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthCustomController::class, 'register'])->name('auth.register.post');

Route::post('/logout', [AuthCustomController::class, 'logout'])->name('auth.logout');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->prefix('test')->group(function () {
    Route::get('/profile', [ProfileController::class, 'halamanProfile'])
        ->name('test.profile');

    Route::patch('/profile/update', [ProfileController::class, 'update'])
        ->name('test.profile.update');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{id}', [MenuController::class, 'showDetail'])->name('menu.show');
Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.show');
Route::match(['get', 'post'], '/kalkulator', [HomeController::class, 'kalkulator'])->name('kalkulator');



Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('menu', AdminMenuController::class);
    Route::resource('artikel', AdminArtikelController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('kategori', AdminKategoriController::class);
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});

Route::post(
    '/admin/users/{id}/toggle-status',
    [AdminController::class, 'toggleStatus']
)->middleware(['auth', 'admin'])->name('admin.users.toggleStatus');

