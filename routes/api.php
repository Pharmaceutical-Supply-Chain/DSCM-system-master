<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardControllers\DrugController;
use App\Http\Controllers\DashboardControllers\HomeController;
use App\Http\Controllers\DashboardControllers\UserController;
use App\Http\Controllers\DashboardControllers\OrderController;
use App\Http\Controllers\DashboardControllers\StockController;
use App\Http\Controllers\DashboardControllers\DrugTypeController;
use App\Http\Controllers\DashboardControllers\EmployeeController;
use App\Http\Controllers\DashboardControllers\RetailerController;
use App\Http\Controllers\DashboardControllers\WholesalerController;
use App\Http\Controllers\DashboardControllers\OrderDetailsController;
use App\Http\Controllers\DashboardControllers\StockDetailsController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function() {

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout']);

    // User Resource Cotroller
    Route::get('/users/wholesalers', [UserController::class, 'getWholesalers']);
    Route::get('/users/retailers', [UserController::class, 'getRetailers']);
    Route::get('/users/employees', [UserController::class, 'getEmployees']);
    Route::resource('/users', UserController::class);

    // Order
    Route::get('/orders/buyerOrders', [OrderController::class, 'getBuyerOrders']);
    Route::get('/orders/sellerOrders', [OrderController::class, 'getSellerOrders']);
    Route::put('/orders/performOrder/{order}', [OrderController::class, 'performOrder']);
    Route::resource('/orders', OrderController::class);

    // Order Details
    Route::get('/order/orderDetails/{order}', [OrderDetailsController::class, 'getOrderDetails']);
    Route::get('orderDetails/{orderDetails}', [OrderDetailsController::class, 'show']);
    Route::put('orderDetails/{orderDetails}', [OrderDetailsController::class, 'update']);
    Route::delete('orderDetails/{orderDetails}', [OrderDetailsController::class, 'destroy']);
    Route::resource('/orderDetails', OrderDetailsController::class);

    // Stock
    Route::resource('/stocks', StockController::class);

    // Stock Details
    Route::get('/getStockDetailsOfUser/{user}', [StockDetailsController::class, 'getStockDetailsOfUser']);

    Route::get('/stock/stockDetails/{stock}', [StockDetailsController::class, 'getStockDetails']);
    Route::get('stockDetails/{stockDetails}', [StockDetailsController::class, 'show']);
    Route::put('stockDetails/{stockDetails}', [StockDetailsController::class, 'update']);
    Route::delete('stockDetails/{stockDetails}', [StockDetailsController::class, 'destroy']);
    Route::resource('/stockDetails', StockDetailsController::class);

    //drug
    Route::get('/durgs/index', [DrugController::class, 'index']);
    Route::post('/durgs/store', [DrugController::class, 'store']);
    Route::get('/durgs/show/{id}', [DrugController::class, 'show']);
    Route::patch('/durgs/update/{id}', [DrugController::class, 'update']);
    Route::delete('/durgs/destroy/{id}', [DrugController::class, 'destroy']);

    Route::get('/drugs/getDrugsByType/{drugType}', [DrugController::class, 'getDrugsByType']);

    //drugType
    Route::get('/durgType/index', [DrugTypeController::class, 'index']);
    Route::post('/durgType/store', [DrugTypeController::class, 'store']);
    Route::get('/durgType/show/{id}', [DrugTypeController::class, 'show']);
    Route::patch('/durgType/update/{id}', [DrugTypeController::class, 'update']);
    Route::delete('/durgType/destroy/{id}', [DrugTypeController::class, 'destroy']);

    // Home Controller
    Route::get('/clients', [HomeController::class, 'displayClients']);
    Route::get('/monitoring', [HomeController::class, 'drugShortageAlert']); 
    Route::get('/sellers', [HomeController::class, 'sellers']);
    Route::get('/search/{name}', [HomeController::class, 'search']); 
    // Route::get('/autocomplete', [HomeController::class, 'autocomplete']);
    
    // Role Controller
    Route::resource('role', RoleController::class);
});
