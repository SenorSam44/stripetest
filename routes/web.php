<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use  App\Http\Controllers\SubscriptionController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
//    Route::get('/plan', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//    Route::get('/plan/{plan}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//    Route::get('/subscription', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//    Route::get('/create-plan', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//    Route::get('/store-plan', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::apiResource('/plan', PlanController::class);
    Route::apiResource('/subscription', SubscriptionController::class);
    Route::post('/subscribe-to/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
    Route::post('/edit-subscription/{subscription}', [SubscriptionController::class, 'editSubscription'])->name('subscription.edit');
    Route::post('/delete-subscription/{subscription}', function () {
        return view('welcome');
    })->name('subscriptiondelete');

});
