<?php
use Illuminate\Support\Facades\Route;
use Modules\Vpanel\Http\Requests\MainRequestController;

////Route::post('login', [UserController::class, 'login']);
////Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);
//
//Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
//    Route::get('', function (Request $request) {
//        return $request->user();
//    });
//    Route::get('settings', function (Request $request) {});
//    Route::post('create', function (Request $request) {});
//});
//

Route::group(['prefix' => 'vpanel', 'middleware' => 'auth:sanctum'], function () {
    Route::get('menu', [MainRequestController::class, 'getMenu']);
});

