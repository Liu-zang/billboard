<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$middleware = [
    'throttle:200:1'
];

Route::group(['middleware' => $middleware, 'prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', 'AuthController@login');
    });


    // 公佈欄管理
    Route::group(['prefix' => 'billboard'], function () {
        // 新增公佈欄資訊
        Route::post('/', 'BillboardController@create')->name('billboard@create');
        // 取得公佈欄列表
        Route::get('/', 'BillboardController@show')->name('billboard@readList');
        // 取得單筆公佈欄資訊
        Route::get('/{id}', 'BillboardController@read')->name('billboard@readSingle');
        // 更新公佈欄資訊
        Route::patch('/{id}', 'BillboardController@update')->name('billboard@update');
        // 刪除公佈欄資訊
        Route::delete('/{id}', 'BillboardController@delete')->name('billboard@delete');
    });

    // 公佈欄分類管理
    Route::group(['prefix' => 'billboardType'], function () {
        // 新增公佈欄分類
        Route::post('/', 'BillboardTypeController@create')->name('billboardType@create');
        // 取得公佈欄分類列表
        Route::get('/', 'BillboardTypeController@show')->name('billboardType@readList');
        // 取得單筆公佈欄分類
        Route::get('/{id}', 'BillboardTypeController@read')->name('billboardType@readSingle');
        // 更新公佈欄分類
        Route::patch('/{id}', 'BillboardTypeController@update')->name('billboardType@update');
        // 刪除公佈欄分類
        Route::delete('/{id}', 'BillboardTypeController@delete')->name('billboardType@delete');
    });
});
