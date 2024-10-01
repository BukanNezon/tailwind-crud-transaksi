<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Product\ProductIndex;
use App\Livewire\Kategori\KategoriIndex;
use App\Livewire\Transaksi\TransaksiForm;
use App\Livewire\Transaksi\TransaksiIndex;
use App\Http\Controllers\PDFController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', ProductIndex::class)->name('product.index');
Route::get('/kategori', KategoriIndex::class)->name('kategori.index');
Route::get('/transaksi', TransaksiIndex::class)->name('transaksi.index');
Route::get('/transaksi/create', TransaksiForm::class)->name('transaksi.form');
Route::get('/print-struk/{id}', [PDFController::class, 'printStruk'])->name('print-struk');