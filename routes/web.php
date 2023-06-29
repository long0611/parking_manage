<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController as user;
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

Route::get('/', [user::class , "welcome"])->name("welcome");
Route::get('/detect_plate/{filename}' , [user::class , "detectPlate"])->name("detectPlate");
Route::get('/quanlyben' , [user::class , "quanlyben"])->name("quanLyBen");
Route::get('/lichsuben' , [user::class , "lichsuben"])->name("lichsuben");
Route::get('/getLichSu' , [user::class , "getLichSu"])->name("getLichSu");
Route::post('/themben' , [user::class , "themBen"])->name("themBenMoi");
Route::post('/themkhu' , [user::class , "themKhu"])->name("themKhuMoi");
Route::post('/uploadFile', [user::class, 'uploadFile'])->name('uploadFile');
Route::get('/ajax_getemptyslot' , [user::class , 'getEmptySlot'])->name('getEmptySlot');
Route::post('/ajax_uploadNewSlot' , [user::class , 'uploadNewSlot'])->name('uploadNewSlot');
Route::get('/getSlotDetail/{slot}' , [user::class , 'getSlotDetail'])->name("getSlotDetail");
Route::get('/getSlotDetailUUID/{uuid}' , [user::class , 'getSlotDetailUUID'])->name("getSlotDetail");
Route::get('/finishSlotWithUUID/{uuid}' , [user::class , 'finishSlotWithUUID']);
Route::get('/finishSlot/{slotid}/{khuslotid}' , [user::class , 'finishSlot'])->name("finishSlot");