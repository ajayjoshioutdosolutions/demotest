<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\CurrencyConvertor;

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

    // 3.1 Count of all active and verified users.
    $users = User::Status('Active')->get();

    // 3.2. Count of active and verified users who have attached active products.

    $usersProductsAttached = User::Status('Active')->whereHas('products')->get();

    // 3.3. Count of all active products (just from products table).

    $products = Product::Status('Active')->get();

    // 3.4. Count of active products which don't belong to any user.

    $productsDoesntHaveUsers = Product::Status('Active')->doesnthave('users')->get();
    

    return view('welcome',compact('users','usersProductsAttached','products','productsDoesntHaveUsers'));
});

Route::get('currency-convert',CurrencyConvertor::class);
