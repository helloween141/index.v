<?php
use Illuminate\Support\Facades\Route;
use Modules\Vpanel\Http\Requests\MainRequestController;

Route::group(['prefix' => 'vpanel'], function () {
    Route::get('/menu', [MainRequestController::class, 'getMenu']);
    Route::get('/interface/{moduleName}/{modelName}', [MainRequestController::class, 'getInterface']);
    Route::get('/data/{moduleName}/{modelName}/{recordId?}', [MainRequestController::class, 'getData']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', function (Request $request) {
        return Auth::user();
    });
    Route::get('/profile', function (Request $request) {});
    Route::post('/create', function (Request $request) {});
});