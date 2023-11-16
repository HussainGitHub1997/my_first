<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Models\Record;
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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('user',UserController::class);
Route::resource('subscr',SubscriptionController::class);
Route::resource('term',TermController::class);
Route::resource('unit',UnitController::class);
Route::resource('sub',SubjectController::class);
Route::resource('re',RecordController::class);



