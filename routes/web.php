<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleArusUangMasuk;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ModuleArusUangKeluar;
use App\Http\Controllers\MasterMotorController;
use App\Http\Controllers\ModulePenyewaanController;
use App\Http\Controllers\ModulePengembalianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/



Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout']);

Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::group(['prefix' => '/master-data', 'middleware' => ['auth']], function () {
    Route::prefix('/master-motor')->group(function () {
        Route::get('/', [MasterMotorController::class, 'index']);
        Route::get('/list-data', [MasterMotorController::class, 'listData']);
        Route::get('{id}/info', [MasterMotorController::class, 'viewForm']);
        Route::get('{id}/edit', [MasterMotorController::class, 'editForm']);
        Route::post('{id}/edit', [MasterMotorController::class, 'updateData']);
        Route::get('/add', [MasterMotorController::class, 'addForm']);
        Route::post('/add', [MasterMotorController::class, 'addData']);
    });
});

Route::group(['prefix' => '/module-manajemen', 'middleware' => ['auth']], function () {
    Route::prefix('/module-sewa')->group(function () {
        Route::get('/', [ModulePenyewaanController::class, 'index']);
        Route::get('/list-data', [ModulePenyewaanController::class, 'listData']);
        Route::get('{id}/info', [ModulePenyewaanController::class, 'viewForm']);
        Route::get('{id}/edit', [ModulePenyewaanController::class, 'editForm']);
        Route::post('{id}/edit', [ModulePenyewaanController::class, 'updateData']);
        Route::get('/add', [ModulePenyewaanController::class, 'addForm']);
        Route::post('/add', [ModulePenyewaanController::class, 'addData']);
    });

    Route::prefix('/module-kembali')->group(function () {
        Route::get('/', [ModulePengembalianController::class, 'index']);
        Route::get('/list-data', [ModulePengembalianController::class, 'listData']);
        Route::get('{id}/info', [ModulePengembalianController::class, 'viewForm']);
        Route::get('{id}/edit', [ModulePengembalianController::class, 'editForm']);
        Route::post('{id}/edit', [ModulePengembalianController::class, 'updateData']);
        Route::get('/add', [ModulePengembalianController::class, 'addForm']);
        Route::post('/add', [ModulePengembalianController::class, 'addData']);
        Route::get('{id}/return', [ModulePengembalianController::class, 'returnMotor']);
    });
});

Route::group(['prefix' => '/module-arus-uang', 'middleware' => ['auth']], function () {
    Route::prefix('/module-arus-uang-masuk')->group(function () {
        Route::get('/', [ModuleArusUangMasuk::class, 'index']);
        Route::get('/list-data', [ModuleArusUangMasuk::class, 'listData']);
        // Route::get('{id}/info', [ModulePenyewaanController::class, 'viewForm']);
        // Route::get('{id}/edit', [ModulePenyewaanController::class, 'editForm']);
        // Route::post('{id}/edit', [ModulePenyewaanController::class, 'updateData']);
        // Route::get('/add', [ModulePenyewaanController::class, 'addForm']);
        // Route::post('/add', [ModulePenyewaanController::class, 'addData']);
    });
    Route::prefix('/module-arus-uang-keluar')->group(function () {
        Route::get('/', [ModuleArusUangKeluar::class, 'index']);
        Route::get('/list-data', [ModuleArusUangKeluar::class, 'listData']);
        // Route::get('{id}/info', [ModulePenyewaanController::class, 'viewForm']);
        // Route::get('{id}/edit', [ModulePenyewaanController::class, 'editForm']);
        // Route::post('{id}/edit', [ModulePenyewaanController::class, 'updateData']);
        // Route::get('/add', [ModulePenyewaanController::class, 'addForm']);
        // Route::post('/add', [ModulePenyewaanController::class, 'addData']);
    });
});

Route::group(['prefix' => '/resources', 'middleware' => ['auth']], function () {
    Route::get('/list-all-motor', [MasterMotorController::class, 'listAllDataMotor']);
    Route::get('/list-motor', [MasterMotorController::class, 'listDataMotor']);
    Route::get('/{id}/list-motor', [MasterMotorController::class, 'listDataMotor']);
    Route::get('/list-motor-sewa', [MasterMotorController::class, 'listDataRented']);
    Route::get('/data-penyewaan', [ModulePenyewaanController::class, 'dataPenyewaan']);
});
