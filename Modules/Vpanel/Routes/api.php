<?php
use Illuminate\Support\Facades\Route;
use Modules\Vpanel\Http\Requests\MainRequestController;

Route::group(['prefix' => 'vpanel'], function () {
    Route::get('/menu', [MainRequestController::class, 'getMenu']);
    Route::get('/interface/{moduleName}/{modelName}', [MainRequestController::class, 'getInterface']);
    Route::get('/list/{moduleName?}/{modelName?}', [MainRequestController::class, 'getList']);
    Route::get('/pointer', [MainRequestController::class, 'getPointer']);
    Route::get('/record/{moduleName}/{modelName}/{id?}', [MainRequestController::class, 'getRecord']);
    Route::post('/{moduleName}/{modelName}/save', [MainRequestController::class, 'saveRecord']);
    Route::post('/{moduleName}/{modelName}/delete/{id}', [MainRequestController::class, 'deleteRecord']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', function (Request $request) {
        return Auth::user();
    });
    Route::get('/profile', function (Request $request) {});
    Route::post('/create', function (Request $request) {});
});