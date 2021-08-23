<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('login', 'AuthController@login')->name('login');
Route::get('grant-auth/{employee_number}/{area_code}', 'AuthController@grant_auth');
Route::get('grant-auth-guest/{employee_number}', 'AuthController@grant_auth_guest');
Route::get('leadtime-monitoring-mail', 'LeadtimeMailController@send_email');
// -------------------- views ---------------------------
Route::group(['middleware' => ['auth']], function() {
Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('dashboard', 'PageController@view_dashboard_page')->name('dashboard');
Route::get('master-data', 'PageController@view_master_page');
Route::get('reprint', 'PageController@view_reprinting_documents_page');
Route::get('irreg-create', 'PageController@view_irregularity_create_page');
Route::get('irreg-update', 'PageController@view_irregularity_update_page');
Route::get('irreg-print', 'PageController@view_irregularity_print_page');
Route::get('leadtime-data', 'PageController@view_leadtime_data_page');
Route::get('monitoring-report', 'PageController@view_monitoring_report_page');
Route::get('parts-status', 'PageController@view_parts_status_page');
Route::get('delivery-data', 'PageController@view_delivery_data_page');
Route::get('checking', 'PageController@view_checking');
Route::get('palletizing', 'PageController@view_palletizing');
Route::get('update-delivery', 'PageController@update_delivery');
Route::get('receiving', 'PageController@receiving');
Route::get('users', 'PageController@view_users');
Route::post('import_excel', 'UploadController@import')->name('import_excel');

Route::get('print-dr-making', 'PrintController@print_parts_for_dr_making');
Route::get('lead-time-report', 'PageController@view_leadtime_report');
Route::get('pallet-report', 'PageController@view_pallet_report');
Route::get('overall-graph-report', 'PageController@view_overall_graph_report');
Route::get('forecast', 'PageController@view_forecast_page');
Route::get('picker', 'PageController@view_picker');

});

Route::fallback(function() {
    if (Auth::check())
        return view('Admin.dashboard');
    else
        return view('login');
});
