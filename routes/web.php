<?php
use App\Models\Page;
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

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => ["auth"]], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'access:' . Page::PAGES["complete_order"]], function () {
        Route::get('/completeorders', 'HomeController@completeOrders')->name('completeorders');
        Route::get('/orderdetail/{id}', 'HomeController@getOrderDetail')->name('orderdetail');
    });
    
    Route::group(['middleware' => 'access:' . Page::PAGES["search_window"]], function () {
        Route::get('search-window', 'HomeController@searchWindow')->name('search-window');
        Route::post('search-window', 'HomeController@postSearchWindow');
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["order_search"]], function () {
        Route::get('order-search', 'HomeController@searchOrder')->name('order-search');
        Route::post('order-search', 'HomeController@postSearchOrder');
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["stock_window"]], function () {
        Route::get('stock-window', 'HomeController@stockWindow')->name('stock-window');
        Route::post('post-stock-window', 'HomeController@postStockWindow')->name('post-stock-window');
        Route::get('get-current-weight', 'HomeController@getCurrentWeight')->name('get-current-weight');
        Route::get('window-relocate', 'HomeController@getWindowRelocate')->name('window-relocate');
        Route::post('window-relocate', 'HomeController@postWindowRelocate')->name('post-window-relocate');
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["capacity_reset"]], function () {
        Route::get('/capacity/get-current-capacity', 'CapacityController@getCurrentCapacity')->name('get-current-capacity');
        Route::resource('capacity', 'CapacityController');
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["edit_record"]], function () {
        Route::get('edit-records', 'HomeController@editRecords')->name('edit-records');
        Route::post('delete-records', 'HomeController@deleteRecords')->name('delete-records');
        Route::post('get-records', 'HomeController@getRecords')->name('get-records');
        Route::get('edit-record/{id}', 'HomeController@getRecord')->name('edit-record');
        Route::post('edit-record/{id}', 'HomeController@postRecord');

    });

    Route::group(['middleware' => 'access:' . Page::PAGES["upload_request"]], function () {
        Route::post('upload-request', 'HomeController@postUploadRequest');
        Route::get('upload-request', 'HomeController@uploadRequest')->name('upload-request');
        Route::get('get-upload-request', 'HomeController@getUploadRequest')->name('get-upload-request');
        Route::get('delete-upload/{id}', 'HomeController@deleteUpload')->name('delete-upload');
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["database"]], function () {
        Route::get('all-data', 'HomeController@getAllData')->name('all-data');
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["rack_info"]], function () {
        Route::get('rack-info/{name}', 'HomeController@getRackInfo')->name('rack-info')->where(['name' => '[A-Ma-m]']);;
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["settings"]], function () {
        Route::get('settings', 'HomeController@settings')->name('settings');
        Route::post('post-settings', 'HomeController@postSettings')->name('post-settings');
    });

    Route::group([  'middleware' => 'access:' . Page::PAGES["users"]], function () {
        Route::resource('user', 'UserController');
    });

    Route::group([  'middleware' => 'access:' . Page::PAGES["location_information"]], function () {
        Route::get('location-information','LocationInformationController@index')->name('location-information');
        Route::get('get-location-information', 'LocationInformationController@getLocationInformation')->name('get-location-information');
    });

    Route::group([  'middleware' => 'access:' . Page::PAGES["covid_19_questions"]], function () {
        Route::get('covid-19-data/create', 'Covid19DataController@create')->name('covid-19-data.create');
        Route::post('covid-19-data', 'Covid19DataController@store')->name('covid-19-data.store');
        Route::post('get-covid-19-data', 'Covid19DataController@getData')->name('covid-19-data.getData');
        Route::post('get-covid-19-data/export', 'Covid19DataController@export')->name('covid-19-data.export');
    });

    Route::group([  'middleware' => 'access:' . Page::PAGES["covid_19_data"]], function () {
        Route::get('covid-19-data', 'Covid19DataController@index')->name('covid-19-data.index');
    });


    Route::group(['middleware' => 'access:' . Page::PAGES["dealer_registration"]], function () {
        Route::get('dealer-registration', 'DealerController@index')->name('dealer.registration');
        Route::post('post-dealer-registration', 'DealerController@postDealerRegister')->name('post-dealer-registration');
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["dealer"]], function () {
        Route::get('dealer', 'DealerController@dealer_login')->name('dealer.login');
        Route::post('post-dealer-login', 'DealerController@postDealerLogin')->name('post-dealer-login');
    });

    Route::group(['middleware' => 'access:' . Page::PAGES["dealer_info"]], function () {
        Route::get('dealer-info', 'DealerController@dealer_info')->name('dealer.info');
        Route::post('post-receive-order', 'DealerController@postReceiveOrder')->name('post-receive-order');
    });

    Route::group([  'middleware' => 'access:' . Page::PAGES["dealers"]], function () {
        Route::resource('dealers', 'DealersController');
    });

    Route::group([  'middleware' => 'access:' . Page::PAGES["departments"]], function () {
        Route::resource('department', 'DepartmentController');
    });
});
