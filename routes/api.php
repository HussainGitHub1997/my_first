<?php

use App\Http\Controllers\Api\RecordController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SignUpController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\Api\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware([ 'auth:sanctum'])->group(function () {

    Route::post('add_term', [TermController::class, 'add']);
    Route::post('edit_term', [TermController::class, 'edit']);
    Route::post('delete_term', [TermController::class, 'delete']);

    Route::post('add_unit', [UnitController::class, 'add']);
    Route::post('edit_unit', [UnitController::class, 'edit']);
    Route::post('delete_unit', [UnitController::class, 'delete']);

    Route::post('add_subject', [SubjectController::class, 'add']);
    Route::post('edit_subject', [SubjectController::class, 'edit']);
    Route::post('delete_subject', [SubjectController::class, 'delete']);

    Route::post('delete_record', [RecordController::class, 'delete']);
    Route::post('add_record', [RecordController::class, 'add']);
    Route::post('edit_record', [RecordController::class, 'edit']);

});

Route::post('/login_admin', [RegisterController::class, 'login_admin']);
Route::post('/login_custmer', [RegisterController::class, 'login_custmer']);
Route::post('/sign_up', [SignUpController::class, 'sign_up']);

Route::get('show_term', [TermController::class, 'show']);
Route::get('index_term', [TermController::class, 'index']);

Route::get('show_record', [RecordController::class, 'show']);
Route::get('index_record', [RecordController::class, 'index']);

Route::get('show_subject', [SubjectController::class, 'show']);
Route::get('index_subject', [SubjectController::class, 'index']);

Route::get('show_unit', [UnitController::class, 'show']);
Route::get('index_unit', [UnitController::class, 'index']);





