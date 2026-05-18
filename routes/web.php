<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MasterDataColumnController as AdminMasterDataColumnController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\GuestListController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/guest-list', [GuestListController::class, 'index'])->name('guest-list.index');
    Route::get('/guest-list/create', [GuestListController::class, 'create'])->name('guest-list.create');
    Route::post('/guest-list', [GuestListController::class, 'store'])->name('guest-list.store');
    Route::get('/guest-list/{guest}', [GuestListController::class, 'show'])->name('guest-list.show');
    Route::delete('/guest-list/{guest}', [GuestListController::class, 'destroy'])->name('guest-list.destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('master-data-columns', [AdminMasterDataColumnController::class, 'index'])->name('master-data-columns.index');
        Route::get('master-data-columns/create', [AdminMasterDataColumnController::class, 'create'])->name('master-data-columns.create');
        Route::post('master-data-columns', [AdminMasterDataColumnController::class, 'store'])->name('master-data-columns.store');
        Route::resource('users', AdminUserController::class);
    });

require __DIR__.'/auth.php';
