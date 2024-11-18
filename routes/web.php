<?php

use App\Http\Controllers\ContohController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Default route to show the login page
Route::get('/', function () {
    return view('login');
});

// Authentication routes (accessible without auth middleware)
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Routes for users with 'user' role
Route::middleware(['auth', 'user-access:user'])->prefix('user')->group(function () {
    // Route to ContohController with tampilContoh method
    Route::get('/home', [ContohController::class, 'tampilContoh']);
    // Route to ProdukController with ViewProduk method to display product list
    Route::get('/produk', [ProdukController::class, 'ViewProduk']);
    // Route to show add product form
    Route::get('/produk/add', [ProdukController::class, 'ViewAddProduk']);
    // Route to process product addition via POST
    Route::post('/produk/add', [ProdukController::class, 'CreateProduk']);
    // Route to delete product based on kode_produk using DELETE method
    Route::delete('/produk/delete/{kode_produk}', [ProdukController::class, 'DeleteProduk']);
    // Route to show edit product form based on kode_produk
    Route::get('/produk/edit/{kode_produk}', [ProdukController::class, 'ViewEditProduk']);
    // Route to process product update via PUT
    Route::put('/produk/edit/{kode_produk}', [ProdukController::class, 'UpdateProduk']);
    // Route to display product report
    Route::get('/laporan', [ProdukController::class, 'ViewLaporan']);
    // Route to generate product report in PDF format
    Route::get('/report', [ProdukController::class, 'print']);
});

// Routes for users with 'admin' role
Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->group(function () {
    // Route to ContohController with tampilContoh method
    Route::get('/home', [ContohController::class, 'tampilContoh']);
    // Route to ProdukController with ViewProduk method to display product list
    Route::get('/produk', [ProdukController::class, 'ViewProduk']);
    // Route to show add product form
    Route::get('/produk/add', [ProdukController::class, 'ViewAddProduk']);
    // Route to process product addition via POST
    Route::post('/produk/add', [ProdukController::class, 'CreateProduk']);
    // Route to delete product based on kode_produk using DELETE method
    Route::delete('/produk/delete/{kode_produk}', [ProdukController::class, 'DeleteProduk']);
    // Route to show edit product form based on kode_produk
    Route::get('/produk/edit/{kode_produk}', [ProdukController::class, 'ViewEditProduk']);
    // Route to process product update via PUT
    Route::put('/produk/edit/{kode_produk}', [ProdukController::class, 'UpdateProduk']);
    // Route to display product report
    Route::get('/laporan', [ProdukController::class, 'ViewLaporan']);
    // Route to generate product report in PDF format
    Route::get('/report', [ProdukController::class, 'print']);
    // Route to admin dashboard view
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
    // Additional admin routes for managing users, settings, etc.
});
