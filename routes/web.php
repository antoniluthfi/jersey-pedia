<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;
use App\Http\Livewire\ProductIndex;
use App\Http\Livewire\ProductLiga;
use App\Http\Livewire\ProductDetail;
use App\Http\Livewire\Keranjang;
use App\Http\Livewire\Checkout;
use App\Http\Livewire\History;
use App\Http\Livewire\Admin;
use App\Http\Livewire\AdminDetail;

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

Auth::routes();

Route::get('/', Home::class)->name('home');
Route::get('/products', ProductIndex::class)->name('product');
Route::get('/products/liga/{id}', ProductLiga::class)->name('product.liga');
Route::get('/products/{id}', ProductDetail::class)->name('product.detail');
Route::get('/keranjang', Keranjang::class)->name('keranjang');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/history', History::class)->name('history');
Route::get('/admin', Admin::class)->name('admin');
Route::get('/admin-detail', AdminDetail::class)->name('admin.detail');