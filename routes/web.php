<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MasterMotorController;

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

Route::group(['prefix' => '/master-data', 'middleware' => ['auth']], function(){
    Route::prefix('/master-motor')->group(function(){
        Route::get('/', [MasterMotorController::class, 'index']);
        Route::get('/list-data', [MasterMotorController::class, 'listData']);
        Route::get('{id}/info', [MasterMotorController::class, 'viewForm']);
        Route::get('/add', [MasterMotorController::class, 'addForm']);
        Route::post('/add', [MasterMotorController::class, 'addData']);

    });
});

