<?php
use Illuminate\Support\Facades\Route;
use Modules\Vpanel\Http\Requests\MainRequestController;

Route::group(['prefix' => 'vpanel'], function () {
    Route::get('menu', [MainRequestController::class, 'getMenu']);
});

