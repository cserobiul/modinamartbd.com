<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

//Frontend Routes
Route::get('/home',[\App\Http\Controllers\Frontend\FrontendController::class,'home'])->name('home');
Route::get('products/{slug}',[\App\Http\Controllers\Frontend\FrontendController::class,'productDetailsSlug'])->name('productDetailsSlug');
Route::get('quick-view/{slug}',[\App\Http\Controllers\Frontend\FrontendController::class,'productQuickView'])->name('productQuickView');
Route::get('categories',[\App\Http\Controllers\Frontend\FrontendController::class,'categoryPage'])->name('categoryPage');
Route::get('categories/{slug}',[\App\Http\Controllers\Frontend\FrontendController::class,'categoryDetailsSlug'])->name('categoryDetailsSlug');
Route::get('brands',[\App\Http\Controllers\Frontend\FrontendController::class,'brandPage'])->name('brandPage');
Route::get('brands/{slug}',[\App\Http\Controllers\Frontend\FrontendController::class,'brandDetailsSlug'])->name('brandDetailsSlug');
Route::get('about-us',[\App\Http\Controllers\Frontend\FrontendController::class,'aboutUs'])->name('aboutUs');
Route::get('search',[\App\Http\Controllers\Frontend\FrontendController::class,'searchPage'])->name('searchPage');
Route::get('contact-us',[\App\Http\Controllers\Frontend\FrontendController::class,'contactUs'])->name('contactUs');
Route::get('shop',[\App\Http\Controllers\Frontend\FrontendController::class,'shopPage'])->name('shopPage');
Route::get('cart',[\App\Http\Controllers\Frontend\CartController::class,'cart'])->name('cartPage');
Route::get('checkout-page',[\App\Http\Controllers\Frontend\CartController::class,'checkoutPage'])->name('checkoutPage');
Route::post('checkout-page',[\App\Http\Controllers\Frontend\CartController::class,'checkoutPageProcess'])->name('checkoutPageProcess');
Route::get('login-register',[\App\Http\Controllers\Frontend\CartController::class,'loginRegister'])->name('loginRegister');
Route::get('order-place-success',[\App\Http\Controllers\Frontend\CartController::class,'orderPlaceSuccess'])->name('orderPlaceSuccess');

Route::get('allClearNOptimizedByApolDotComDotBD',[\App\Http\Controllers\Frontend\FrontendController::class,'allClearNOptimized'])->name('allClearNOptimized');

Route::get('login-register-popup',[\App\Http\Controllers\Frontend\FrontendController::class,'loginRegisterPopUp'])->name('loginRegisterPopUp');


Route::get('/logout', function () {
    auth()->logout();
    return redirect()->route('home');
});

//Backend Routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('dashboard',[\App\Http\Controllers\Frontend\FrontendController::class,'dashboard'])->name('dashboard');
    Route::get('customer-order-details/{cusId}/{oId}','\App\Http\Controllers\Frontend\FrontendController@customerSingleOrderDetails')->name('customerSingleOrderDetails');
    Route::get('customer-profile-update','\App\Http\Controllers\Frontend\FrontendController@dashboard')->name('customerProfileUpdateGet');
    Route::post('customer-profile-update','\App\Http\Controllers\Frontend\FrontendController@customerProfileUpdate')->name('customerProfileUpdate');

    Route::resource('product',\App\Http\Controllers\Backend\ProductController::class);

    //User and Role
    Route::resource('role',\App\Http\Controllers\Backend\RolePermissionController::class);
    Route::get('permission', \App\Http\Controllers\Backend\PermissionController::class);
    Route::post('permission','\App\Http\Controllers\Backend\PermissionController@store')->name('permission.store');
//    Route::post('permission', \App\Http\Controllers\Backend\PermissionController::class,'store')->name('permission.store');
    Route::resource('user',\App\Http\Controllers\Backend\UserController::class);
    Route::get('profile/edit','\App\Http\Controllers\Backend\UserController@profileEdit')->name('profile.edit');
    Route::put('profile/update','\App\Http\Controllers\Backend\UserController@profileUpdate')->name('profile.update');

    //Order Routes
    Route::resource('order',\App\Http\Controllers\Backend\OrderController::class);
    Route::get('order-new','\App\Http\Controllers\Backend\OrderController@newOrder')->name('newOrder');
    Route::get('order-confirmed','\App\Http\Controllers\Backend\OrderController@confirmedOrder')->name('confirmedOrder');
    Route::get('order-shipping','\App\Http\Controllers\Backend\OrderController@shippingOrder')->name('shippingOrder');
    Route::get('order-delivered','\App\Http\Controllers\Backend\OrderController@deliveredOrder')->name('deliveredOrder');

    //Order Status Change Routes
    Route::post('order-new','\App\Http\Controllers\Backend\OrderController@statusCancelOrConfirmed')->name('statusCancelOrConfirmed');
    Route::post('order-confirmed','\App\Http\Controllers\Backend\OrderController@statusConfirmedToShipping')->name('statusConfirmedToShipping');
    Route::post('order-shipping','\App\Http\Controllers\Backend\OrderController@statusShippingToDelivered')->name('statusShippingToDelivered');


    Route::resource('supplier',\App\Http\Controllers\Backend\SupplierController::class);
    Route::resource('customer',\App\Http\Controllers\Backend\CustomerController::class);
    Route::resource('purchase',\App\Http\Controllers\Backend\PurchaseController::class);
    Route::get('stock','\App\Http\Controllers\Backend\PurchaseController@stock')->name('stock.index');
    Route::get('product-purchase-cart','\App\Http\Controllers\Backend\PurchaseController@index');
    Route::post('product-purchase-cart','\App\Http\Controllers\Backend\PurchaseController@producttemp')->name('purchase.product.add');
    Route::delete('product-purchase-del/{id}','\App\Http\Controllers\Backend\PurchaseController@producttempdel')->name('purchase.product.dell');

    Route::resource('sale',\App\Http\Controllers\Backend\SaleController::class);

    //Settings
    Route::resource('brand',\App\Http\Controllers\Backend\BrandController::class);
    Route::resource('payment_method',\App\Http\Controllers\Backend\PaymentMethodController::class);
    Route::resource('size',\App\Http\Controllers\Backend\SizeController::class);
    Route::resource('color',\App\Http\Controllers\Backend\ColorController::class);
    Route::resource('unit',\App\Http\Controllers\Backend\UnitController::class);
    Route::resource('warranty',\App\Http\Controllers\Backend\WarrantyController::class);
    Route::resource('category',\App\Http\Controllers\Backend\CategoryController::class);
    Route::resource('settings',\App\Http\Controllers\Backend\SettingsController::class);

    Route::resource('slider',\App\Http\Controllers\Backend\SliderController::class);
    Route::resource('notebook',\App\Http\Controllers\Backend\NotebookController::class);

    //Accounts - buyer - offline customer
    Route::get('accounts/due-collection','\App\Http\Controllers\Backend\SaleTransactionController@buyerDueCollection')->name('buyerDueCollection');
    Route::post('accounts/due-collection','\App\Http\Controllers\Backend\SaleTransactionController@buyerDueCollectionProcess')->name('buyerDueCollectionProcess');

    //Accounts - online customer
    Route::get('accounts/bill-collection','\App\Http\Controllers\Backend\AccountsController@billCollection')->name('billCollection');
    Route::post('accounts/bill-collection','\App\Http\Controllers\Backend\AccountsController@billCollectionProcess')->name('billCollectionProcess');

    Route::get('accounts/buyer-due-check/{buyer_id}','\App\Http\Controllers\Backend\SaleTransactionController@buyerDueCheck')->name('buyerDueCheck');
    Route::get('accounts/customer-due-check/{customer_id}','\App\Http\Controllers\Backend\AccountsController@customerDueCheck')->name('customerDueCheck');
    Route::get('accounts/supplier-due-check/{supplier_id}','\App\Http\Controllers\Backend\AccountsController@supplierDueCheck')->name('supplierDueCheck');

    Route::get('accounts/bill-collection-from-shipping','\App\Http\Controllers\Backend\AccountsController@billCollectionFromShipping')->name('billCollectionFromShipping');
    Route::post('accounts/bill-collection-from-shipping','\App\Http\Controllers\Backend\AccountsController@billCollectionProcessFromShipping')->name('billCollectionProcessFromShipping');

    Route::get('accounts/bill-paid','\App\Http\Controllers\Backend\AccountsController@billPaid')->name('billPaid');
    Route::post('accounts/bill-paid','\App\Http\Controllers\Backend\AccountsController@billPaidProcess')->name('billPaidProcess');

    //Product Return - Customer
    Route::get('accounts/customer-return-product','\App\Http\Controllers\Backend\ProductReturnController@customerProductReturn')->name('customerProductReturn');
    Route::post('accounts/customer-return-product','\App\Http\Controllers\Backend\ProductReturnController@customerProductReturnProcess')->name('customerProductReturnProcess');
    Route::post('accounts/customer-return-product/store','\App\Http\Controllers\Backend\ProductReturnController@customerProductReturnProcessStore')->name('customerProductReturnProcessStore');

    Route::get('accounts/customer-product/{order_id}','\App\Http\Controllers\Backend\ProductReturnController@customerProductCheck')->name('customerProductCheck');

    //Product Return - Buyer
    Route::get('accounts/buyer-return-product','\App\Http\Controllers\Backend\ProductReturnController@buyerProductReturn')->name('buyerProductReturn');
    Route::post('accounts/buyer-return-product','\App\Http\Controllers\Backend\ProductReturnController@buyerProductReturnProcess')->name('buyerProductReturnProcess');
    Route::post('accounts/buyer-return-product/store','\App\Http\Controllers\Backend\ProductReturnController@buyerProductReturnProcessStore')->name('buyerProductReturnProcessStore');

    Route::get('accounts/buyer-product/{invoice_no}','\App\Http\Controllers\Backend\ProductReturnController@buyerProductCheck')->name('buyerProductCheck');



    Route::get('accounts/supplier-return-product','\App\Http\Controllers\Backend\ProductReturnController@supplierProductReturn')->name('supplierProductReturn');
    Route::post('accounts/supplier-return-product','\App\Http\Controllers\Backend\ProductReturnController@supplierProductReturnProcess')->name('supplierProductReturnProcess');

    Route::get('accounts/product-price-check/{product_id}','\App\Http\Controllers\Backend\ProductReturnController@productPriceCheck')->name('productPriceCheck');
    Route::get('purchase/product-price-check/{product_id}','\App\Http\Controllers\Backend\ProductReturnController@productPriceCheck')->name('purchaseProductPriceCheck');
    Route::get('sale/product-price-check/{product_id}','\App\Http\Controllers\Backend\ProductController@productPriceCheck')->name('saleProductPriceCheck');

    Route::get('report/buyer-list','\App\Http\Controllers\Backend\ReportController@buyerList')->name('buyerList');
    Route::get('report/customer-list','\App\Http\Controllers\Backend\ReportController@customerList')->name('customerList');

    //Reporting
    Route::get('report/supplier-due','\App\Http\Controllers\Backend\ReportController@supplierDue')->name('supplier.due');
    Route::get('report/supplier-due-details/{supplier_id}','\App\Http\Controllers\Backend\ReportController@supplierDueDetails')->name('supplier.due.details');
    Route::get('report/supplier-product-return','\App\Http\Controllers\Backend\ReportController@supplierReturnList')->name('supplierReturnList');
    Route::get('report/supplier-wise-product-return/{supplier_id}','\App\Http\Controllers\Backend\ReportController@supplierReturnDetails')->name('supplierReturnDetails');
    Route::get('report/supplier-product-return-details/{return_id}','\App\Http\Controllers\Backend\ReportController@supplierProductReturnDetails')->name('supplierProductReturnDetails');

    Route::get('report/buyer-due','\App\Http\Controllers\Backend\ReportController@buyerDue')->name('buyer.due');
    Route::get('report/buyer-due-details/{buyer_id}','\App\Http\Controllers\Backend\ReportController@buyerDueDetails')->name('buyer.due.details');
    Route::get('report/buyer-product-return','\App\Http\Controllers\Backend\ReportController@buyerReturnList')->name('buyerReturnList');
    Route::get('report/buyer-wise-product-return/{buyer_id}','\App\Http\Controllers\Backend\ReportController@buyerReturnDetails')->name('buyerReturnDetails');
    Route::get('report/buyer-product-return-details/{return_id}','\App\Http\Controllers\Backend\ReportController@buyerProductReturnDetails')->name('buyerProductReturnDetails');

    Route::get('report/buyer-point','\App\Http\Controllers\Backend\ReportController@buyerPoint')->name('buyerPoint');
    Route::get('report/buyer-point-details/{buyer_id}','\App\Http\Controllers\Backend\ReportController@buyerPointDetails')->name('buyerPointDetails');


    Route::get('report/customer-due','\App\Http\Controllers\Backend\ReportController@customerDue')->name('customer.due');
    Route::get('report/customer-due-details/{customer_id}','\App\Http\Controllers\Backend\ReportController@customerDueDetails')->name('customer.due.details');
    Route::get('report/customer-product-return','\App\Http\Controllers\Backend\ReportController@customerReturnList')->name('customerReturnList');
    Route::get('report/customer-wise-product-return/{customer_id}','\App\Http\Controllers\Backend\ReportController@customerReturnDetails')->name('customerReturnDetails');
    Route::get('report/customer-product-return-details/{return_id}','\App\Http\Controllers\Backend\ReportController@customerProductReturnDetails')->name('customerProductReturnDetails');

    Route::get('report/customer-point','\App\Http\Controllers\Backend\ReportController@customerPoint')->name('customerPoint');
    Route::get('report/customer-point-details/{customer_id}','\App\Http\Controllers\Backend\ReportController@customerPointDetails')->name('customerPointDetails');


    //Print
    Route::get('invoice-print/{order_id}','\App\Http\Controllers\Backend\PrintController@invoicePrint')->name('invoice.print');
    Route::get('sale-invoice-print/{sale_id}','\App\Http\Controllers\Backend\PrintController@saleInvoicePrint')->name('sale.print');
    Route::get('buyer-due-collection-invoice/{sale_transaction_id}','\App\Http\Controllers\Backend\PrintController@buyerDueCollectionInvoicePrint')->name('buyerDueCollectionInvoicePrint');

});

Route::get('/', function () {
    return view('welcome');
});
