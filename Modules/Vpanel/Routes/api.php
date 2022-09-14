<?php

use Illuminate\Support\Facades\Route;
use Modules\Vpanel\Http\Controllers\MainRequestController;

Route::group(['prefix' => 'vpanel', 'middleware' => 'auth'], function () {
    Route::get('/menu', [MainRequestController::class, 'getMenu']);
    Route::get('/interface/{moduleName}/{modelName}', [MainRequestController::class, 'getInterface']);
    Route::get('/list/{moduleName?}/{modelName?}', [MainRequestController::class, 'getList']);
    Route::get('/record/{moduleName}/{modelName}/{id?}', [MainRequestController::class, 'getRecord']);
    Route::get('/{moduleName}/{modelName}/delete/{id}', [MainRequestController::class, 'deleteRecord']);
    Route::post('/{moduleName}/{modelName}/save/{id}', [MainRequestController::class, 'saveRecord']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', function (Request $request) {
        return Auth::user();
    });
    Route::get('/profile', function (Request $request) {});
    Route::post('/create', function (Request $request) {});
});
