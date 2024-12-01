<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Add routes for admin profile
    Route::get('/admin/profile', [AdminProfileController::class, 'show'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    // Hotels routes
    Route::prefix('admin/hotels')->name('admin.hotels.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{hotel}', [AdminController::class, 'show'])->name('show');
        Route::get('/{hotel}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{hotel}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{hotel}', [AdminController::class, 'destroy'])->name('destroy');
    });

    // Bookings routes
    Route::prefix('admin/bookings')->name('admin.bookings.')->group(function () {
        Route::get('/', [AdminController::class, 'bookingsIndex'])->name('index');
        Route::get('/{booking}', [AdminController::class, 'bookingsShow'])->name('show');
        Route::get('/{booking}/edit', [AdminController::class, 'bookingsEdit'])->name('edit');
        Route::put('/{booking}', [AdminController::class, 'bookingsUpdate'])->name('update');
        Route::delete('/{booking}', [AdminController::class, 'bookingsDestroy'])->name('destroy');
    });
});

Route::middleware(['role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/profile/update', [UserProfileController::class, 'update'])->name('user.profile.update');
    // Add this new route for availability checking
    Route::get('/check-availability', [UserController::class, 'checkAvailability'])->name('user.checkAvailability');
    
    Route::prefix('bookings')->name('user.bookings.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{booking}', [UserController::class, 'show'])->name('show');
        Route::get('/{booking}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [UserController::class, 'update'])->name('update');
        Route::delete('/{booking}', [UserController::class, 'destroy'])->name('destroy');
    });
});


require __DIR__.'/auth.php';