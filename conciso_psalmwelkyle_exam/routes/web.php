<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;


use App\Models\Product;


// Welcome/products page
Route::get('/', function (Request $request) { 
    $productsQuery = Product::query();

    //  Search
    if ($request->has('search')) {
        $search = $request->input('search');
        $productsQuery->where('name', 'LIKE', "%{$search}%");
    }

    // Sortings
    if ($request->input('sort') === 'price_asc') {
        $productsQuery->orderBy('price', 'asc');
    } else if ($request->input('sort') === 'price_desc') {
        $productsQuery->orderBy('price', 'desc');
    } else {
        $productsQuery->latest(); // Default sort
    }

    $products = $productsQuery->paginate(8)->withQueryString();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'products' => $products,
        'filters' => $request->only(['search', 'sort']),
    ]);
})->name('welcome');

// Authenticated user profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/checkout', [CartController::class, 'store'])->name('cart.store');
    Route::get('/my-orders', [CartController::class, 'index'])->name('my-orders.index');
});

// Admin CMS routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.users.index');
    })->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('products', ProductController::class)->except(['show']);

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});




require __DIR__.'/auth.php';