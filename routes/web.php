<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpotController;
use Illuminate\Support\Facades\Route;

// ADMIN
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
// spots
Route::get('/admin/spot', [SpotController::class, 'index']);
Route::get('/admin/spot/add', [SpotController::class, 'create']);
Route::post('/admin/spot', [SpotController::class, 'store']);
Route::get('/admin/spot/{id}/edit', [SpotController::class, 'edit']);
Route::put('/admin/spot/{id}', [SpotController::class, 'update']);
Route::get('/admin/spot/{id}/delete', [SpotController::class, 'destroy']);

// map and route
Route::get('/', [HomeController::class, 'maps']);
Route::get('/maps/{id}', [HomeController::class, 'getRoute'])->name('cek-rute');
Route::get('/spot/{id}', [HomeController::class, 'detailSpot']);
