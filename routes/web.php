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

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@home_page');
    Route::Post('invoice/sale-price', 'InvoiceController@salePrice')->name('sale-price');
    Route::Post('invoice-refund/sale-price', 'InvoiceRefundController@salePrice')->name('sale-price-refund');
    Route::Post('invoice-refund/purchase-price', 'InvoiceRefundPurchaseController@purchasePrice')->name('purchase-price-refund');
    Route::get('invoice/print/{id}', 'InvoiceController@print');
    Route::get('invoice/pdf/{id}', 'InvoiceController@pdf')->name('send.pdf');
    Route::get('invoice/sendMail/{id}', 'InvoiceController@sendMail')->name('send.email.invoice');
    Route::get('invoice-purchase/print/{id}', 'PurchaseInvoiceController@print');
    Route::resource('payment', 'PaymentController');
    Route::resource('payment-purchase', 'PaymentPurchaseController');
    Route::get('payment-purchase/create/{id}', 'PaymentPurchaseController@create')->name('payment-purchase.create');
    Route::get('payment/create/{id}', 'PaymentController@create')->name('payment.create');
    Route::resource('invoice', 'InvoiceController');
    Route::resource('invoice-refund', 'InvoiceRefundController');
    Route::resource('invoice-refund-purchase', 'InvoiceRefundPurchaseController');
    Route::get('invoice-refund/create/{invoice}', 'InvoiceRefundController@create')->name('invoice-refund.create');
    Route::get('invoice-refund/print/{id}', 'InvoiceRefundController@print');
    Route::get('invoice-refund-purchase/print/{id}', 'InvoiceRefundPurchaseController@print');
    Route::get('invoice-refund-purchase/create/{invoice}', 'InvoiceRefundPurchaseController@create')->name('invoice-refund-purchase.create');
    Route::resource('purchase-invoice', 'PurchaseInvoiceController');
    Route::get('client/print/{client}', 'ClientController@print');
    Route::get('supplier/print/{supplier}', 'SupplierController@print');
    Route::resource('client', 'ClientController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('product', 'ProductController');
    Route::prefix('report')->group(function () {
        Route::get('client_balance', 'ClientReportsController@client_balance')->name('client_balance');
        Route::get('client_balance/search', 'ClientReportsController@client_balance_search')->name('client_balance_search');
        Route::get('client_guide', 'ClientReportsController@client_guide')->name('client_guide');
        Route::get('client_guide/search', 'ClientReportsController@client_guide_search')->name('client_guide_search');
        Route::get('client_payments', 'ClientReportsController@client_payments')->name('client_payments');
        Route::get('client_payments/search', 'ClientReportsController@client_payments_search')->name('client_payments_search');

        Route::get('supplier_balance', 'SupplierReportsController@supplier_balance')->name('supplier_balance');
        Route::get('supplier_balance/search', 'SupplierReportsController@supplier_balance_search')->name('supplier_balance_search');
        Route::get('supplier_guide', 'SupplierReportsController@supplier_guide')->name('supplier_guide');
        Route::get('supplier_guide/search', 'SupplierReportsController@supplier_guide_search')->name('supplier_guide_search');
        Route::get('supplier_payments', 'SupplierReportsController@supplier_payments')->name('supplier_payments');
        Route::get('supplier_payments/search', 'SupplierReportsController@supplier_payments_search')->name('supplier_payments_search');

    });

    Route::get('add-user','UserController@add_user')->name('add.user');
    Route::post('add-user','UserController@create_user')->name('create.user');
    Route::get('profile','UserController@profile')->name('profile.user');
    Route::get('edit-profile','UserController@edit_profile')->name('editProfile.user');
    Route::post('edit-profile','UserController@edit_profile_update')->name('updateProfile.user');
    Route::get('change-password','UserController@change_password')->name('change_password.user');
    Route::post('change-password','UserController@update_password')->name('change_password.user');

    Route::get('demos/jquery-image-upload','DemoController@showJqueryImageUpload');
    Route::post('demos/jquery-image-upload','DemoController@saveJqueryImageUpload');

});

Auth::routes(['register'=> false]);

Route::get('/home', 'HomeController@index')->name('home');
