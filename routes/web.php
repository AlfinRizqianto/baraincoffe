<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pegawai', [EmployeeController::class, 'index'])->name('pegawai');
Route::get('/tambahpegawai', [EmployeeController::class, 'create'])->name('tambahpegawai');
Route::post('/insertdata', [EmployeeController::class, 'store'])->name('insertdata');
Route::get('/editpegawai/{id}', [EmployeeController::class, 'edit'])->name('editpegawai');
Route::post('/updatepegawai/{id}', [EmployeeController::class, 'update'])->name('updatepegawai');
Route::get('/deletepegawai/{id}', [EmployeeController::class, 'destroy'])->name('deletepegawai');

//Export PDF
Route::get('/exportpdf', [EmployeeController::class, 'exportPDF'])->name('exportpdf');
//Export Excel
Route::get('/exportexcel', [EmployeeController::class, 'exportExcel'])->name('exportexcel');
//Import Excel
Route::post('/importexcel', [EmployeeController::class, 'importExcel'])->name('importexcel');
