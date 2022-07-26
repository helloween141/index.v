<?php

use App\Http\Controllers\API\CoreController;
use App\Http\Controllers\API\TaskController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\DashboardController;

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', function (Request $request) {
        return $request->user();
    });
    Route::get('settings', function (Request $request) {});
    Route::post('create', function (Request $request) {});
});

////Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
////    Route::get('executors', [UserController::class, 'getExecutors']);
////});
//
//Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:sanctum'], function () {
//    Route::get('performance', [DashboardController::class, 'getPerformance']);
//    Route::get('active-tasks', [DashboardController::class, 'getActiveTasks']);
//});
//
//Route::group(['prefix' => 'tasks', 'middleware' => 'auth:sanctum'], function () {
//    Route::get('get-all-time', [TaskController::class, 'getAllTime']);
//    Route::post('update-timer', [TaskController::class, 'updateTimer']);
//});
//
//Route::group(['prefix' => 'core', 'middleware' => 'auth:sanctum'], function () {
//    Route::get('{model}/sidebar', [CoreController::class, 'getSidebar']);
//    Route::get('{model}/interface', [CoreController::class, 'getInterface']);
//    Route::get('{model}/search', [CoreController::class, 'getSearchResult']);
//    Route::get('{model}/{recordId}', [CoreController::class, 'getData']);
//    Route::post('{model}/save', [CoreController::class, 'saveData']);
//});
