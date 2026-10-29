<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;

Route::get('/', function () {
    return redirect()->route('pelanggan.index');
});

Route::resource('pelanggan', PelangganController::class);

Route::patch('/pelanggan/{id}/status', [
    PelangganController::class,
    'toggleStatus'
])->name('pelanggan.toggleStatus');