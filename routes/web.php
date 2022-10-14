<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/welcome', 'WelcomeController@listProduct')->name('welcome');
Route::get('/buy/{id}', 'WelcomeController@buy')->name('buy');

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);


    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
    
    //change language
    Route::get('/changeLang','Backend\DashboardController@changeLang')->name('changeLang');



    //article routes
    Route::get('examen-e-commerce/articles/index', 'Backend\ArticleController@index')->name('admin.articles.index');
    Route::get('examen-e-commerce/articles/create', 'Backend\ArticleController@create')->name('admin.articles.create');
    Route::post('examen-e-commerce/articles/store', 'Backend\ArticleController@store')->name('admin.articles.store');
    Route::get('examen-e-commerce/articles/edit/{id}', 'Backend\ArticleController@edit')->name('admin.articles.edit');
    Route::put('examen-e-commerce/articles/update/{id}', 'Backend\ArticleController@update')->name('admin.articles.update');
    Route::delete('examen-e-commerce/articles/destroy/{id}', 'Backend\ArticleController@destroy')->name('admin.articles.destroy');
    Route::get('examen-e-commerce/articles/show-by-deposit/{id}', 'Backend\ArticleController@showByDeposit')->name('admin.articles.show-by-deposit');
    Route::get('examen-e-commerce/articles/show-by-rayon/{id}', 'Backend\ArticleController@showByRayon')->name('admin.articles.show-by-rayon');
    Route::get('examen-e-commerce/articles/show-by-category/{id}', 'Backend\ArticleController@showByCategory')->name('admin.articles.show-by-category');
    Route::post('examen-e-commerce/admin/articles/importCsv','Backend\ArticleController@uploadArticle')->name('admin.articles.importCsv');

    //stockin routes
    Route::get('examen-e-commerce/stockins/index', 'Backend\StockinController@index')->name('admin.stockins.index');
    Route::get('examen-e-commerce/stockins/create', 'Backend\StockinController@create')->name('admin.stockins.create');
    Route::post('examen-e-commerce/stockins/store', 'Backend\StockinController@store')->name('admin.stockins.store');
    Route::get('examen-e-commerce/stockins/edit/{bon_no}', 'Backend\StockinController@edit')->name('admin.stockins.edit');
    Route::put('examen-e-commerce/stockins/update/{bon_no}', 'Backend\StockinController@update')->name('admin.stockins.update');
    Route::delete('examen-e-commerce/stockins/destroy/{bon_no}', 'Backend\StockinController@destroy')->name('admin.stockins.destroy');
    Route::get('examen-e-commerce/stockins/show/{bon_no}', 'Backend\StockinController@show')->name('admin.stockins.show');

    Route::get('examen-e-commerce/stockin/generatepdf','Backend\StockinController@htmlPdf')->name('admin.stockin.generatepdf');

    Route::get('examen-e-commerce/stockin/generatepdf/{numero}','Backend\StockinController@bon_entree')->name('admin.stockin.bon_entree');

    //stockout routes
    Route::get('examen-e-commerce/sales/index', 'Backend\SaleController@index')->name('admin.sales.index');
    Route::get('examen-e-commerce/sales/create', 'Backend\SaleController@create')->name('admin.sales.create');
    Route::post('examen-e-commerce/sales/store', 'Backend\SaleController@store')->name('admin.sales.store');
    Route::get('examen-e-commerce/sales/edit/{bon_no}', 'Backend\SaleController@edit')->name('admin.sales.edit');
    Route::put('examen-e-commerce/sales/update/{bon_no}', 'Backend\SaleController@update')->name('admin.sales.update');
    Route::delete('examen-e-commerce/sales/destroy/{bon_no}', 'Backend\SaleController@destroy')->name('admin.sales.destroy');

    Route::get('examen-e-commerce/stockout/generatepdf','Backend\SaleController@htmlPdf')->name('admin.stockout.generatepdf');
    Route::get('examen-e-commerce/sales/generatepdf/{bon_no}','Backend\SaleController@bon_sortie')->name('admin.sales.bon_sortie');
    Route::get('examen-e-commerce/sales/show/{bon_no}', 'Backend\SaleController@show')->name('admin.sales.show');

    //virtual stock routes
    Route::get('examen-e-commerce/stock-status/index', 'Backend\StockController@index')->name('admin.stock-status.index');
    Route::delete('examen-e-commerce/stocks/destroy/{id}', 'Backend\StockController@destroy')->name('admin.stocks.destroy');
    Route::get('examen-e-commerce/stock-statement_of_needs/need', 'Backend\StockController@need')->name('admin.statement_of_needs.need');
    Route::get('examen-e-commerce/stock-generatepdf/status', 'Backend\StockController@toPdf')->name('admin.stock-status');

    //orders routes
    Route::get('examen-e-commerce/orders/index', 'Backend\OrderController@index')->name('admin.orders.index');
    Route::get('examen-e-commerce/orders/create', 'Backend\OrderController@create')->name('admin.orders.create');
    Route::post('examen-e-commerce/orders/store', 'Backend\OrderController@store')->name('admin.orders.store');
    Route::get('examen-e-commerce/orders/edit/{id}', 'Backend\OrderController@edit')->name('admin.orders.edit');
    Route::put('examen-e-commerce/orders/update/{id}', 'Backend\OrderController@update')->name('admin.orders.update');
    Route::delete('examen-e-commerce/supplier_requisitions/destroy/{id}', 'Backend\OrderController@destroy')->name('admin.orders.destroy');

    Route::get('examen-e-commerce/orders/show/{bon_no}', 'Backend\OrderController@show')->name('admin.orders.show');

    Route::get('examen-e-commerce/orders/generatepdf/{bon_no}','Backend\OrderController@htmlPdf')->name('admin.orders.generatepdf');
    Route::put('examen-e-commerce/orders/validate/{bon_no}', 'Backend\OrderController@validateCommand')->name('admin.orders.validate');
    Route::put('examen-e-commerce/orders/reject/{bon_no}','Backend\OrderController@reject')->name('admin.orders.reject');
    Route::put('examen-e-commerce/orders/reset/{bon_no}','Backend\OrderController@reset')->name('admin.orders.reset');
    Route::put('examen-e-commerce/orders/confirm/{bon_no}','Backend\OrderController@confirm')->name('admin.orders.confirm');
    Route::put('examen-e-commerce/orders/approuve/{bon_no}','Backend\OrderController@approuve')->name('admin.orders.approuve');
    Route::put('examen-e-commerce/orders/reception/{bon_no}','Backend\OrderController@reception')->name('admin.orders.reception');



     Route::get('examen-e-commerce/categories/index', 'Backend\CategoryController@index')->name('admin.categories.index');
    Route::get('examen-e-commerce/categories/create', 'Backend\CategoryController@create')->name('admin.categories.create');
    Route::post('examen-e-commerce/categories/store', 'Backend\CategoryController@store')->name('admin.categories.store');
    Route::get('examen-e-commerce/categories/edit/{id}', 'Backend\CategoryController@edit')->name('admin.categories.edit');
    Route::put('examen-e-commerce/categories/update/{id}', 'Backend\CategoryController@update')->name('admin.categories.update');
    Route::delete('examen-e-commerce/categories/destroy/{id}', 'Backend\CategoryController@destroy')->name('admin.categories.destroy');

    Route::get('examen-e-commerce/category_rayons/index', 'Backend\CategoryRayonController@index')->name('admin.category_rayons.index');
    Route::get('examen-e-commerce/category_rayons/create', 'Backend\CategoryRayonController@create')->name('admin.category_rayons.create');
    Route::post('examen-e-commerce/category_rayons/store', 'Backend\CategoryRayonController@store')->name('admin.category_rayons.store');
    Route::get('examen-e-commerce/category_rayons/edit/{id}', 'Backend\CategoryRayonController@edit')->name('admin.category_rayons.edit');
    Route::put('examen-e-commerce/category_rayons/update/{id}', 'Backend\CategoryRayonController@update')->name('admin.category_rayons.update');
    Route::delete('examen-e-commerce/category_rayons/destroy/{id}', 'Backend\CategoryRayonController@destroy')->name('admin.category_rayons.destroy');

    //Reports routes
    Route::get('examen-e-commerce/report/stock/day','Backend\ReportController@dayReport')->name('admin.report.stock.day');
    Route::get('examen-e-commerce/report/stock/month','Backend\ReportController@monthReport')->name('admin.report.stock.month');
    Route::get('examen-e-commerce/report/stock/personalized','Backend\ReportController@personalizedReport')->name('admin.report.stock.personalized');
    Route::get('examen-e-commerce/report/stock/getPersonalized/report',function(){
        return view('backend.pages.report.personalized_report.index');
    });
    Route::get('examen-e-commerce/report/stock/year','Backend\ReportController@yearReport')->name('admin.report.stock.year');

    //settings routes
    Route::get('examen-e-commerce/settings/index', 'Backend\SettingController@index')->name('admin.settings.index');
     Route::get('musumba-cloud-stocks/documentation/index', 'Backend\SettingController@documentation')->name('admin.documentation.index');
    Route::get('examen-e-commerce/settings/create', 'Backend\SettingController@create')->name('admin.settings.create');
    Route::post('examen-e-commerce/settings/store', 'Backend\SettingController@store')->name('admin.settings.store');
    Route::get('examen-e-commerce/settings/edit/{id}', 'Backend\SettingController@edit')->name('admin.settings.edit');
    Route::put('examen-e-commerce/settings/update/{id}', 'Backend\SettingController@update')->name('admin.settings.update');
    Route::delete('examen-e-commerce/settings/destroy/{id}', 'Backend\SettingController@destroy')->name('admin.settings.destroy');

    Route::post('/admin/system/db-backup','Backend\SettingController@postDbBackUp'
    )->name('admin.system.dbBackup');

    Route::get('/404/muradutunge/ivyomwasavye-ntibishoboye-kuboneka',function(){
        return view('errors.404');


    });
});
