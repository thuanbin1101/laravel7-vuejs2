<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Order;
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
    return view('welcome');
});

Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');



// ------------------------------------------------------------..


// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Route::any('{slug}',function(){
//     return view('welcome');
// });

// Route::get('/test', function (Request $request) {
//     $response = response('asd',200);
//     dd($request->id);
// });


// Route::get('/category', function () {
//     $category = new Category();
//     $category->name = "Quan ao";
//     $category->save();
// });
// Route::get('/delete/category', function () {
//     $category = Category::find(1)->delete();
// });
// Route::get('/restore/category', function () {
//     Category::withTrashed()->find(1)->restore();
// });
// Route::get('/product-category', function () {
//     // tim cac hoa don co cai product nay
//     // $orders = Product::find(1)->orders;
//     // // dd($orders);
//     // foreach ($orders as $order) {
//     //     echo $order->pivot->created_at;
//     // }
//     // dd($orders);
//     // tim cac san pham thuoc cai hoa don nay
//     // $products = Order::find(1)->products;
//     // dd($products);
//     DB::connection()->enableQueryLog();
//     $posts = Order::withCount('products')->get();
//     $queries = \DB::getQueryLog();
//     return dd($queries);

//     foreach ($posts as $post) {
//         echo $post->products_count;
//     }
// });
