<?php

use App\Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard/register', Register::class)
    ->name('filament.dashboard.auth.register')
    ->middleware('signed')
    ->middleware('guest');
