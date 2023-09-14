<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WidgetController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('widgets.index');
});

Route::middleware('web')->group(function () {
    Route::resource('widgets', WidgetController::class)
        ->parameters(['widgets' => 'widget'])->except(['show']);

    Route::resource('packing', PackingController::class)
        ->only(['index','store']);

    Route::resource('orders', OrderController::class)
        ->parameters(['orders' => 'order'])->only(['index','show']);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
