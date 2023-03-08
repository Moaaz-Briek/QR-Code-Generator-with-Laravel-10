<?php

use App\Http\Controllers\QrController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [QrController::class, 'index'])->name('home');
Route::post('/qr-builder', [QrController::class, 'do_qr_builder'])->name('do_qr_builder');
Route::get('/phone', [QrController::class, 'phone'])->name('qr_phone');;
Route::get('/email', [QrController::class, 'email'])->name('qr_email');;
Route::get('/geo', [QrController::class, 'geo'])->name('qr_geo');;
Route::get('/sms', [QrController::class, 'sms'])->name('qr_sms');;

