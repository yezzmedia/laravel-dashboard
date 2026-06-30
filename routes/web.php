<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::post('/logout', function () {
    auth()->guard('web')->logout();

    session()->invalidate();

    session()->regenerateToken();

    return redirect('/');
})->name('logout');
