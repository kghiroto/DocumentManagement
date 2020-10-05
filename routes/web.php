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

#Route::get('/', function () {
#    return view('welcome');
#});

# 例外
Route::get('/exception-error', function () {
    return view('errors.exception-error');
});

# see vendor/laravel/framework/src/Illuminate/Routing/Router.php
Auth::routes();

# この中はログインしている場合のみルーティングされる
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //Route::get('quotation/create-input','QuotationController@getCreateInput')->name('quotation/create-input');
    //Route::post('password/create-confirm','PasswordController@postCreateConfirm')->name('password/create-confirm');
    //Route::post('password/create-finish','PasswordController@postCreateFinish')->name('password/create-finish');
    //Route::get('password/list',    'PasswordController@getList')->name('password/list');
    //Route::get('password/edit-input/{id}','PasswordController@getEditInput')->name('password/edit-input')->where('id', '[0-9]+');//->middleware('auth.password');
    //Route::post('password/edit-confirm','PasswordController@postEditConfirm')->name('password/edit-confirm');
    //Route::post('password/edit-finish','PasswordController@postEditFinish')->name('password/edit-finish');

    // pdf 表示
    Route::get('quotation/pdf/{id}','QuotationController@showPdf')->name('quotation/pdf')->where('id', '[0-9]+');
    // 案件一覧
    Route::get('quotation/list','QuotationController@showList')->name('quotation/list');
    // 案件表示
    Route::get('quotation/show/{id}','QuotationController@show')->name('quotation/show')->where('id', '[0-9]+');
    // 案件編集入力
    Route::get('quotation/edit-input/{id}','QuotationController@editInput')->name('quotation/edit-input')->where('id', '[0-9]+');
    // 案件転記
    Route::get('quotation/copy-input/{id}','QuotationController@copyInput')->name('quotation/copy-input')->where('id', '[0-9]+');
    // 案件新規入力
    Route::get('quotation/create-input','QuotationController@createInput')->name('quotation/create-input');
    // 案件保存
    Route::post('quotation/save','QuotationController@save')->name('quotation/save');
    // プレビュー
    Route::post('quotation/preview','QuotationController@preview')->name('quotaion/preview');
    // プレビュー
    Route::get('quotation/preview','QuotationController@preview')->name('quotaion/preview');
    // EXCEL
    Route::post('quotation/excel','QuotationController@excel')->name('quotaion/excel');
    // EXCEL
    Route::get('quotation/excel','QuotationController@excel')->name('quotaion/excel');
    // 案件検索API
    Route::get('quotation/search-quotations-api','QuotationController@searchQuotationsApi')->name('quotation/search-quotations-api');
    // 顧客先検索Ajax
    Route::get('ajax/search-customer','QuotationController@searchCustomer');
    // 参照複写検索Ajax
    Route::get('ajax/search-quotation','QuotationController@searchQuotation');
    // 参照複写詳細検索Ajax
    Route::get('ajax/search-quotation-detail','QuotationController@searchQuotationDetail');
    // ソートAjax
    Route::post('ajax/sort-quotation','QuotationController@sortQuotation');
    // 案件詳細検索API
    Route::get('quotation/search-quotation-details-api','QuotationController@searchQuotationDetailsApi')->name('quotation/search-quotation-details-api');
    // 見積もり検索
    Route::post('quotation/list','QuotationController@searchList')->name('quotation/list');

    // 会員一覧
    Route::get('customer/list','CustomerController@showList')->name('customer/list');
    // 案件表示
    Route::get('customer/show/{id}','CustomerController@show')->name('customer/show')->where('id', '[0-9]+');
    // 案件編集入力
    Route::get('customer/edit-input/{id}','CustomerController@editInput')->name('customer/edit-input')->where('id', '[0-9]+');
    // 案件新規入力
    Route::get('customer/create-input','CustomerController@createInput')->name('customer/create-input');
    // 案件保存
    Route::post('customer/save','CustomerController@save')->name('customer/save');
});
