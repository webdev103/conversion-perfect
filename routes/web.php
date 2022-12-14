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
Route::get('/', 'IndexController@index');

Auth::routes();

Route::group(['domain' => '{sub_domain}.cnvp.me'], function () {
    Route::get('/{link_name}', 'Api/OverlaysController@index');
});

Route::group(['domain' => '{sub_domain}.cnvp.in'], function () {
    Route::get('/{link_name}', 'Api/OverlaysController@index');
});

Route::get('/connect-aweber', 'Api\BarOptionsApiController@connectAweber')->name('integration.aweber-connect');
Route::get('/connect-constant-contact', 'Api\BarOptionsApiController@connectConstantContact')->name('integration.constant-contact-connect');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'Users\DashboardController@index')->name('customer.dashboard');
    Route::get('/sub-domain-register', 'Users\DashboardController@subDomainRegister');
    Route::post('/sub-domain-register', 'Users\DashboardController@setSubDomainRegister')->name('domain.register');
    Route::get('/training', 'Users\DashboardController@trainingIndex')->name('training');
    Route::get('/bonuses', 'Users\DashboardController@bonusesIndex')->name('bonuses');
    Route::get('/account', 'Users\DashboardController@profileIndex')->name('account');
    Route::resource('bars', 'Users\BarsController', ['names' => ['index' => 'bars']]);
    Route::resource('groups', 'Users\GroupsController', ['names' => ['index' => 'groups']]);
    Route::resource('email-lists', 'Users\EmailListsController', ['names' => ['index' => 'email-lists']]);
    Route::post('/hide-option/{id}', 'Users\BarOptionsController@hideBarOption');
    Route::post('/save-option/{id}', 'Users\BarOptionsController@saveBarOption');
    Route::post('/clear-option/{id}', 'Users\BarOptionsController@clearBarOption');
    Route::post('/image-upload/{id}', 'Users\BarOptionsController@uploadImageFile');
    Route::get('/get-responder-lists', 'Api\BarOptionsApiController@getAutoResponderLists');
    Route::get('/get-html-integration-code', 'Api\BarOptionsApiController@getHtmlIntegrationCode');
    Route::resource('split-tests', 'Users\SplitTestsController', ['names' => ['index' => 'split-tests']]);
    Route::resource('multi-bars', 'Users\MultiBarsController', ['names' => ['index' => 'multi-bars']]);
    
    Route::resource('autoresponder', 'AutoResponderController');
});
