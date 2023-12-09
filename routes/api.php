<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\services\crypt\AESServices;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {

    Route::group([
        'prefix' => 'record'
    ], function () {
        Route::post('{user}', [RecordController::class, 'store']);
        Route::put('{user}/{record}', [RecordController::class, 'update']);
        Route::delete('{user}/{record}', [RecordController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'subscription'
    ], function () {
        Route::post('{user}', [SubscriptionController::class, 'store']);
        Route::put('{user}/{subscription}', [SubscriptionController::class, 'update']);
        Route::delete('{user}/{subscription}', [SubscriptionController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'unit'
    ], function () {
        Route::post('{user}', [UnitController::class, 'store']);
        Route::put('{user}/{unit}', [UnitController::class, 'update']);
        Route::delete('{user}/{unit}', [UnitController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'subject'
    ], function () {
        Route::post('{user}', [SubjectController::class, 'store']);
        Route::put('{user}/{subject}', [SubjectController::class, 'update']);
        Route::delete('{user}/{subject}', [SubjectController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'section'
    ], function () {
        Route::post('{user}', [SectionController::class, 'store']);
        Route::put('{user}/{section}', [SectionController::class, 'update']);
        Route::delete('{user}/{section}', [SectionController::class, 'destroy']);
    });
});


Route::post('/login/admin', [UserController::class, 'loginAdmin']);
Route::post('/login/custmer', [UserController::class, 'loginCustmer']);
Route::post('/signup', [UserController::class, 'signup']);

Route::get('show/section/{section}', [SectionController::class, 'show']);
Route::get('index/section', [SectionController::class, 'index']);

Route::get('show/record/{record}', [RecordController::class, 'show']);
Route::get('index/record', [RecordController::class, 'index']);

Route::get('show/subscription/{subscription}', [SubscriptionController::class, 'show']);
Route::get('index/subscription', [SubscriptionController::class, 'index']);


Route::get('show/subject/{subject}', [SubjectController::class, 'show']);
Route::get('index/subject', [SubjectController::class, 'index']);

Route::get('show/unit/{unit}', [UnitController::class, 'show']);
Route::get('index/unit', [UnitController::class, 'index']);


Route::controller(AESServices::class)->group(function () {
    Route::post('upload', 'upload');
    Route::get('encryption/{file_name}', 'encryption');
    Route::get('decription/{file_name}', 'decription');
    Route::get('show/{file_name}', 'show');
});

Route::get('generateCode',[UserController::class,"generateCode"]);