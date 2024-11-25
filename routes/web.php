<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/*
 * this is a particular routes --------------------------------------------------------------------------
 */

// Group of routes accessible only by users with the 'admin' role
Route::middleware(['role:admin'])->group(function () {
    // Admin dashboard route
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('hotels', HotelController::class);
    Route::resource('bookings', BookingController::class)->only(['index', 'edit', 'update', 'destroy', 'show']);
});

// Group of routes accessible only by users with the 'user' role
Route::middleware(['role:user'])->group(function () {
    // User dashboard route
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
});

/*
 * it ends here ----------------------------------------------------------------------------------------
 */



require __DIR__.'/auth.php';
