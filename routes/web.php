<?php

use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicineReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::resource('medicines', MedicineController::class);

    Route::get('/reports', [MedicineReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/available', [MedicineReportController::class, 'available'])->name('reports.available');
    Route::get('/reports/expired', [MedicineReportController::class, 'expired'])->name('reports.expired');
    Route::get('/reports/low-stock', [MedicineReportController::class, 'lowStock'])->name('reports.low_stock');
    Route::get('/reports/inventory', [MedicineReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/export/{type}', [MedicineReportController::class, 'exportCsv'])->name('reports.export');
});

require __DIR__.'/auth.php';
