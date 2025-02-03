<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/admin/login'));
Route::get('/admin', fn() => redirect('/admin/login'));
Route::get('/login', fn() => redirect('/admin/login'));
