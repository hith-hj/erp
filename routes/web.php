<?php

use App\Http\Controllers\Bill\BillController;
use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\Currency\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Material\MaterialController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Section\SectionController;
use App\Models\Sale;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware'=>'auth',],function(){
    Route::view('/','main.main');

    Route::group([
        'prefix'=>'card',
        'controller'=>CardController::class
        ],function(){
        Route::get('all','index')->name('card.all');
        Route::get('show/{id}','show')->name('card.show');
        Route::get('create/{type}','create')->name('card.create');
        Route::post('store','store')->name('card.store');
        Route::get('edit/{id}','edit')->name('card.edit');
        Route::post('update/{id}','update')->name('card.update');
        Route::get('delete/{id}','delete')->name('card.delete');

    });
    Route::group([
        'prefix'=>'user',
        'controller'=>UserController::class
        ],function(){
        Route::get('all','index')->name('user.all');
        Route::get('show/{id}','show')->name('user.show');
        Route::get('create','create')->name('user.create');
        Route::post('create','store')->name('user.store');
        Route::post('update/{id}','update')->name('user.update');
        Route::delete('delete/{user}','delete')->name('user.delete');
    });
    Route::group([
        'prefix'=>'material',
        'controller'=>MaterialController::class
        ],function(){
        Route::get('all','index')->name('material.all');
        Route::get('show/{id}','show')->name('material.show');
        Route::get('create','create')->name('material.create');
        Route::post('store','store')->name('material.store');
    });
    Route::group([
        'prefix'=>'inventory',
        'controller'=>InventoryController::class
        ],function(){
        Route::get('all','index')->name('inventory.all');
        Route::get('show/{id}','show')->name('inventory.show');
        Route::get('create','create')->name('inventory.create');
        Route::post('store','store')->name('inventory.store');
        Route::post('{inventory_id}/material/store','material_store')->name('inventory.material.store');
        Route::get('{inventory_id}/material/{material_id}/delete','material_delete')->name('inventory.material.delete');
    });
    Route::group([
        'prefix'=>'currency',
        'controller'=>CurrencyController::class
        ],function(){
        Route::get('all','index')->name('currency.all');
        Route::get('show/{id}','show')->name('currency.show');
        Route::get('create','create')->name('currency.create');
        Route::get('store','store')->name('currency.store');
        Route::post('rates/store','currency_rate_store')->name('currency.rates.store');
    });
    Route::group([
        'prefix'=>'purchase',
        'controller'=>PurchaseController::class
        ],function(){
        Route::get('all','index')->name('purchase.all');
        Route::get('show/{id}','show')->name('purchase.show');
        Route::get('create','create')->name('purchase.create');
        Route::post('store','store')->name('purchase.store');
        Route::get('delete/{id}','delete')->name('purchase.delete');
    });
    Route::group([
        'prefix'=>'sale',
        'controller'=>SaleController::class
        ],function(){
        Route::get('all','index')->name('purchase.all');
        Route::get('show/{id}','show')->name('purchase.show');
        Route::get('create','create')->name('purchase.create');
        Route::post('store','store')->name('purchase.store');
        Route::get('delete/{id}','delete')->name('purchase.delete');
    });
    Route::group([
        'prefix'=>'bill',
        'controller'=>BillController::class
    ],function(){
        Route::get('all','index')->name('bill.all');        
        Route::get('show/{id}','show')->name('bill.show');
        Route::get('create','create')->name('bill.create');
        Route::post('store','store')->name('bill.store');
        Route::delete('delete/{id}','delete')->name('bill.delete');

        Route::post('bill_store_purchase/{id}','bill_store_purchase')->name('bill.store.purchase');
        Route::get('{bill_id}/purchase/{purchase_id}/delete','bill_delete_purchase')->name('bill.delete.purchase');

        Route::post('bill_store_sale/{id}','bill_store_sale')->name('bill.store.sale');
        Route::get('{bill_id}/sale/{sale_id}/delete','bill_delete_sale')->name('bill.delete.sale');

        Route::post('save/{id}','save')->name('bill.save');
        Route::post('audit/{id}','audit')->name('bill.audit');

    });
    
    
    Route::group([
        'prefix'=>'section',
        'controller'=>SectionController::class
        ],function(){
        Route::get('all','index')->name('section.all');
        Route::get('show/{id}','show')->name('section.show');
        Route::get('create','create')->name('section.create');

    });

    Route::group(['controller'=>HomeController::class,],function(){
        Route::get('/home','index')->name('home');
        Route::get('/changePassword/{user}','changePasswordForm');
        Route::post('/changePassword/{user}','changePassword')->name('changePassword');    
    });
});

require(__DIR__.'/CP.php');
Auth::routes();


