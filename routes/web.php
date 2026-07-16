<?php

declare(strict_types=1);

use App\Http\Controllers\DealController;
use App\Http\Controllers\LeadActionController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('leads.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('leads', LeadController::class);
    Route::resource('deals', DealController::class);
    Route::resource('actions', LeadActionController::class);
});

require __DIR__.'/auth.php';
