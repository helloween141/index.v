<?php

use Illuminate\Support\Facades\Route;
use Modules\Vpanel\Http\Controllers\MainRequestController;

Route::group(['prefix' => 'vpanel', 'middleware' => 'auth'], function () {
    Route::get('/menu', [MainRequestController::class, 'getMenu']);
    Route::get('/{moduleName}/{modelName}/interface', [MainRequestController::class, 'getInterface']);
    Route::get('/{moduleName?}/{modelName?}/list', [MainRequestController::class, 'getList']);
    Route::get('/{moduleName}/{modelName}/record/{id?}', [MainRequestController::class, 'getRecord']);
    Route::get('/{moduleName}/{modelName}/delete/{id}', [MainRequestController::class, 'deleteRecord']);
    Route::post('/{moduleName}/{modelName}/save/{id}', [MainRequestController::class, 'saveRecord']);
    Route::post('/{moduleName}/{modelName}/sort-list', [MainRequestController::class, 'sortList']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', function () {
        return Auth::user();
    });
    Route::get('/profile', function (Request $request) {});
    Route::post('/create', function (Request $request) {});
});
