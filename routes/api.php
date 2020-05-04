<?php

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

/**
 * Require the department header
 */
Route::middleware(['department'])->group(function () {

    Route::group(['prefix' => 'plans', 'namespace' => 'Plans', 'middleware' => 'auth'], function () {
        Route::post('/', 'CreatePlan');
        Route::get('/', 'IndexPlans');
    });

    Route::group(['prefix' => 'subscriptions', 'namespace' => 'Subscriptions'], function () {
        Route::post('/', 'CreateSubscription');
        Route::get('/', 'IndexSubscriptions');
    });

    Route::group(['prefix' => 'items', 'namespace' => 'Items'], function () {
        Route::post('/', 'CreateItem');
    });

    Route::group(['namespace' => 'Subscriptions', 'middleware' => 'subscription'],function(){
        Route::get('/support/subscriptions/{type}/{uuid}','RetrieveSubscriptions');
    });
});

