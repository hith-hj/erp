<?php

use App\Http\Controllers\AccountType\AccountTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Bill\BillController;
use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Currency\CurrencyController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Manufacturing\ManufacturingController;
use App\Http\Controllers\Material\MaterialController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Vendors\VendorController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Unit\UnitController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'auth',], function () {
    Route::view('/', 'main.main');

    Route::group([
        'prefix' => 'user',
        'controller' => UserController::class
    ], function () {
        Route::get('all', 'index')->name('user.all');
        Route::get('show/{id}', 'show')->name('user.show');
        Route::get('create', 'create')->name('user.create');
        Route::post('create', 'store')->name('user.store');
        Route::post('update/{id}', 'update')->name('user.update');
        Route::delete('delete/{user}', 'delete')->name('user.delete');
    });

    Route::group([
        'prefix' => 'material',
        'controller' => MaterialController::class
    ], function () {
        Route::get('all', 'index')->name('material.all');
        Route::get('show/{id}', 'show')->name('material.show');
        Route::get('create', 'create')->name('material.create');
        Route::post('store', 'store')->name('material.store');
        Route::delete('delete/{material}', 'delete')->name('material.delete');
        Route::get('create_manufacture_model/{id}', 'createManufactureModel')
            ->name('material.create_manufacture_model');
        Route::post('store_manufacture_model', 'storeMaterialManufactureModel')
            ->name('material.store_manufacture_model');
    });

    Route::group([
        'prefix' => 'inventory',
        'controller' => InventoryController::class
    ], function () {
        Route::get('all', 'index')->name('inventory.all');
        Route::get('show/{id}', 'show')->name('inventory.show');
        Route::get('create', 'create')->name('inventory.create');
        Route::post('store', 'store')->name('inventory.store');
        Route::post('setDefault/{id}','setDefault')->name('inventory.setDefault');
        Route::post('{inventory_id}/material/store', 'material_store')->name('inventory.material.store');
        Route::get('{inventory_id}/material/{material_id}/delete', 'material_delete')->name('inventory.material.delete');
    });

    Route::group([
        'prefix' => 'currency',
        'controller' => CurrencyController::class
    ], function () {
        Route::get('all', 'index')->name('currency.all');
        Route::get('show/{id}', 'show')->name('currency.show');
        Route::get('create', 'create')->name('currency.create');
        Route::post('store', 'store')->name('currency.store');
        Route::delete('delete/{id}', 'delete')->name('currency.delete');
        Route::post('setDefault/{id}','setDefault')->name('currency.setDefault');
    });

    Route::group([
        'prefix' => 'purchase',
        'controller' => PurchaseController::class
    ], function () {
        Route::get('all', 'index')->name('purchase.all');
        Route::get('show/{id}', 'show')->name('purchase.show');
        Route::get('create', 'create')->name('purchase.create');
        Route::post('store', 'store')->name('purchase.store');
        Route::delete('delete/{id}', 'delete')->name('purchase.delete');
        Route::post('{id}/addMaterial','addMaterial')->name('purchase.addMaterial');
        Route::delete('{id}/deleteMaterial','deleteMaterial')->name('purchase.deleteMaterial');

        Route::post('save/{id}', 'save')->name('purchase.save');
        Route::post('audit/{id}', 'audit')->name('purchase.audit');
        Route::post('check/{id}', 'check')->name('purchase.check');
    });

    Route::group([
        'prefix' => 'sale',
        'controller' => SaleController::class
    ], function () {
        Route::get('all', 'index')->name('sale.all');
        Route::get('show/{id}', 'show')->name('sale.show');
        Route::get('create', 'create')->name('sale.create');
        Route::post('store', 'store')->name('sale.store');
        Route::delete('delete/{id}', 'delete')->name('sale.delete');
        Route::post('{id}/addMaterial','addMaterial')->name('sale.addMaterial');
        Route::delete('{id}/deleteMaterial','deleteMaterial')->name('sale.deleteMaterial');

        Route::post('save/{id}', 'save')->name('sale.save');
        Route::post('audit/{id}', 'audit')->name('sale.audit');
        Route::post('check/{id}', 'check')->name('sale.check');
    });

    Route::group([
        'prefix' => 'bill',
        'controller' => BillController::class
    ], function () {
        Route::get('all', 'index')->name('bill.all');
        Route::get('show/{id}', 'show')->name('bill.show');        
    });

    Route::group([
        'prefix' => 'unit',
        'controller' => UnitController::class
    ], function () {
        Route::get('all', 'index')->name('unit.all');
        Route::get('show/{unit}', 'show')->name('unit.show');
        Route::get('create', 'create')->name('unit.create');
        Route::post('store', 'store')->name('unit.store');
        Route::delete('delete/{unit}', 'delete')->name('unit.delete');
    });

    Route::group([
        'prefix' => 'vendor',
        'controller' => VendorController::class
    ], function () {
        Route::get('all', 'index')->name('vendor.all');
        Route::get('show/{vendor}', 'show')->name('vendor.show');
        Route::get('create', 'create')->name('vendor.create');
        Route::post('store', 'store')->name('vendor.store');
        Route::delete('delete/{vendor}', 'delete')->name('vendor.delete');
    });

    Route::group([
        'prefix' => 'client',
        'controller' => ClientController::class
    ], function () {
        Route::get('all', 'index')->name('client.all');
        Route::get('show/{client}', 'show')->name('client.show');
        Route::get('create', 'create')->name('client.create');
        Route::post('store', 'store')->name('client.store');
        Route::delete('delete/{client}', 'delete')->name('client.delete');
    });

    Route::group([
        'prefix' => 'expense',
        'controller' => ExpenseController::class
    ], function () {
        Route::get('all', 'index')->name('expense.all');
        Route::get('show/{expense}', 'show')->name('expense.show');
        Route::get('create', 'create')->name('expense.create');
        Route::post('store', 'store')->name('expense.store');
        Route::delete('delete/{expense}', 'delete')->name('expense.delete');
    });

    Route::group([
        'prefix' => 'accountType',
        'controller' => AccountTypeController::class
    ], function () {
        Route::get('all', 'index')->name('accountType.all');
        Route::get('show/{accountType}', 'show')->name('accountType.show');
        Route::get('create', 'create')->name('accountType.create');
        Route::post('store', 'store')->name('accountType.store');
        Route::delete('delete/{accountType}', 'delete')->name('accountType.delete');
    });
    
    Route::group([
        'prefix' => 'manufacturing',
        'controller' => ManufacturingController::class
    ], function () {
        Route::get('all', 'index')->name('manufacturing.all');
        Route::get('show/{manufacturing}', 'show')->name('manufacturing.show');
        Route::get('create', 'create')->name('manufacturing.create');
        Route::post('store', 'store')->name('manufacturing.store');
        Route::delete('delete/{manufacturing}', 'delete')->name('manufacturing.delete');
    });

    Route::group([
        'prefix' => 'cashier',
        'controller' => CashierController::class
    ], function () {
        Route::get('all', 'index')->name('cashier.all');
        Route::get('show/{cashier}', 'show')->name('cashier.show');
        Route::get('create', 'create')->name('cashier.create');
        Route::post('store', 'store')->name('cashier.store');
        Route::delete('delete/{cashier}', 'delete')->name('cashier.delete');
        Route::post('setDefault/{cashier}','setDefault')->name('cashier.setDefault');
        Route::post('transaction/{cashier}','transaction')->name('cashier.transaction');
        Route::post('transfer/{transaction}','transfer')->name('cashier.transfer');
        Route::post('credits','credits')->name('cashier.credits');
    });

    Route::group(['controller' => HomeController::class,], function () {
        Route::get('/home', 'index')->name('home');
        Route::get('/changePassword/{user}', 'changePasswordForm');
        Route::post('/changePassword/{user}', 'changePassword')->name('changePassword');
        Route::post('themeCustomizer', 'themeCustomizer')->name('themeCustomizer');
    });
});

require (__DIR__ . '/CP.php');
Auth::routes();


