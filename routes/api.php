<?php

use Illuminate\Http\Request;

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

Route::get('print-dr-making', 'DrMakingController@update_dr_making');
Route::get('print-irreg', 'PrintController@print_irregularity');
Route::get('banner-pdf', 'PrintController@print_banner');
Route::get('change-code', 'AuthController@change_code');
Route::get('print-irregularity', 'IrregularityController@load_reprint');
Route::post('irregularity', 'IrregularityController@add_irregularity_item');
