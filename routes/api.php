<?php

use Illuminate\Support\Facades\Route;
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::apiResource('/employee','Api\EmployeeController');
Route::apiResource('/supplier','Api\SupplierController');
Route::apiResource('/category','Api\CategoryController');
Route::apiResource('/product','Api\ProductController');
Route::apiResource('/expense','Api\ExpenseController');
Route::apiResource('/customer','Api\CustomerController');
Route::post('/salary/paid/{id}','Api\SalaryController@Paid');
Route::get('/salary','Api\SalaryController@allSalary');
Route::get('/salary/view/{id}','Api\SalaryController@viewSalary');
Route::get('/edit/salary/{id}','Api\SalaryController@editSalary');
Route::patch('/salary/update/{id}','Api\SalaryController@updateSalary');
Route::patch('/stock/update/{id}','Api\ProductController@stockUpdate');
Route::get('/getting/product/{id}','Api\PosController@getProduct');

// Cart 
Route::get('/addToCart/{id}','Api\CartController@addToCart');
Route::get('/cart/product','Api\CartController@cartProduct');
Route::get('/remove/cart/{id}','Api\CartController@removeCart');
Route::get('/increment/{id}','Api\CartController@increment');
Route::get('/decrement/{id}','Api\CartController@decrement');

// Vat
Route::get('/vats','Api\CartController@vats');

Route::post('/orderdone','Api\PosController@orderDone');
Route::get('/orders','Api\OrderController@todayOrder');
Route::get('/orders/all','Api\OrderController@allOrder');
Route::post('/orders/search','Api\OrderController@searchOrder');
Route::get('/order/details/{id}','Api\OrderController@orderDetails');
Route::get('/order/orderdetails/{id}','Api\OrderController@orderDetailsAll');

// Admin Dashboard
Route::get('/today/sell','Api\PosController@todaySell');
Route::get('/today/income','Api\PosController@todayIncome');
Route::get('/today/due','Api\PosController@todayDue');
Route::get('/today/expense','Api\PosController@todayExpense');
Route::get('/today/stockout','Api\PosController@todayStockout');



