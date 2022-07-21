<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Product;


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

    // 3.5. Amount of all active attached products (if user1 has 3 prod1 and 2 prod2 which are active, user2 has 7 prod2 and 4 prod3, prod3 is inactive, then the amount of active attached products will be 3 + 2 + 7 = 12).
    

    $usersProductsAttached = User::Status('Active')->whereHas('products')->get();
    
    $activeAttachedProductAmount = 0.0;
    
    if($usersProductsAttached)
    foreach($usersProductsAttached as $attachedProductsTotalPrice)
    $activeAttachedProductAmount += $attachedProductsTotalPrice->SumActiveProduct;

    // 3.6. Summarized price of all active attached products (from the previous subpoint if prod1 price is 100$, prod2 price is 120$, prod3 price is 200$, the summarized price will be 3 x 100 + 9 x 120 = 1380).

    $usersProductsAttached = User::Status('Active')->whereHas('products')->get();

    $totalSummerizedPrice = 0;

    if($usersProductsAttached)
    foreach($usersProductsAttached as $attachedProductsSummerize)
    {
        $groupedData = $attachedProductsTotalPrice->products->groupBy('id');
   
        foreach($groupedData as $summery){
            
            $totalSummerizedPrice += count($summery)*$summery[0]->price; //get 1st index only
        }
    }
    

    return view('welcome',compact('users','usersProductsAttached','products','productsDoesntHaveUsers','activeAttachedProductAmount','totalSummerizedPrice'));
});
