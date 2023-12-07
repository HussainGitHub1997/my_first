<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {

    Route::group([
        'prefix' => 'record'
    ], function () {
        Route::post('', [RecordController::class, 'store']);
        Route::put('{record}', [RecordController::class, 'update']);
        Route::delete('{record}', [RecordController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'subscription'
    ], function () {
        Route::post('', [SubscriptionController::class, 'store']);
        Route::put('{subscription}', [SubscriptionController::class, 'update']);
        Route::delete('{subscription}', [SubscriptionController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'unit'
    ], function () {
        Route::post('', [UnitController::class, 'store']);
        Route::put('{unit}', [UnitController::class, 'update']);
        Route::delete('{unit}', [UnitController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'subject'
    ], function () {
        Route::post('', [SubjectController::class, 'store']);
        Route::put('{subject}', [SubjectController::class, 'update']);
        Route::delete('{subject}', [SubjectController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'section'
    ], function () {
        Route::post('', [SectionController::class, 'store']);
        Route::put('{section}', [SectionController::class, 'update']);
        Route::delete('{section}', [SectionController::class, 'destroy']);
    });
});


Route::post('/login/admin', [UserController::class, 'loginAdmin']);
Route::post('/login/custmer', [UserController::class, 'loginCustmer']);
Route::post('/signup', [SignUpController::class, 'signup']);

Route::get('show/section', [SectionController::class, 'show']);
Route::get('index/section', [SectionController::class, 'index']);

Route::get('show/record', [RecordController::class, 'show']);
Route::get('index/record', [RecordController::class, 'index']);

Route::get('show/subscription', [SubscriptionController::class, 'show']);
Route::get('index/subscription', [SubscriptionController::class, 'index']);


Route::get('show/subject', [SubjectController::class, 'show']);
Route::get('index/subject', [SubjectController::class, 'index']);

Route::get('show/{show}', [UnitController::class, 'show']);
Route::get('index/unit', [UnitController::class, 'index']);
