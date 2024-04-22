<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // Check if the authenticated user is an admin
        if (auth()->user()->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        elseif(auth()->user()->user_type === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        } else{
            return view('dashboard');
        }
    })->name('dashboard');

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->middleware(['auth', 'verified'])->name('admin.dashboard');
    
    Route::get('/superadmin', function () {
        return view('superadmin.dashboard');
    })->middleware(['auth', 'verified'])->name('superadmin.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
