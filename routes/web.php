<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Livewire\QrCodePage;

Route::get('/', fn() => redirect('/admin/login'));
Route::get('/login', fn() => redirect('/admin/login'));

Route::get('/qr-code-page/{recordKey}', QrCodePage::class)->name('qr-code.page');
