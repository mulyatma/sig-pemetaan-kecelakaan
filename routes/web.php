<?php

use App\Http\Controllers\Admin\ClusteringController;
use App\Http\Controllers\Admin\RekapKecelakaanController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\KecelakaanController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
Route::get('/register', [\App\Http\Controllers\Admin\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Admin\AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pie-chart-data', [\App\Http\Controllers\Admin\DashboardController::class, 'pieChartData'])->name('pie-chart-data');
    Route::resource('kecelakaan', \App\Http\Controllers\Admin\KecelakaanController::class);
    Route::delete('/hapus-data', [\App\Http\Controllers\Admin\KecelakaanController::class, 'destroyAll'])->name('kecelakaan.destroyAll');
    Route::post('/kecelakaan/import', [ImportController::class, 'import'])->name('kecelakaan.import');
    Route::get('/rekap-kecelakaan', [RekapKecelakaanController::class, 'index'])->name('rekap.index');
    Route::post('/rekap-kecelakaan/proses', [RekapKecelakaanController::class, 'proses'])->name('rekap.proses');
    Route::delete('/cluster/destroy', [ClusteringController::class, 'destroyCluster'])->name('cluster.destroy');
    Route::get('/clustering', [ClusteringController::class, 'index'])->name('clustering.index');
    Route::post('/clustering/proses', [ClusteringController::class, 'proses'])->name('clustering.proses');
    Route::delete('/clustering/destroy', [ClusteringController::class, 'destroyProcess'])->name('clustering.destroy');
    Route::get('/clustering/peta', [ClusteringController::class, 'showMap'])->name('clustering.map');
});

Route::get('/', function () {
    return view('pages.user.index');
});
Route::get('/kecelakaan', [KecelakaanController::class, 'index'])->name('kecelakaan.index');

Route::get('/kecelakaan/locations', [HomeController::class, 'getLocations'])->name('get.kecelakaan.locations');
Route::get('/kecelakaan/map', [HomeController::class, 'showMapUser'])->name('clustering.map.user');
