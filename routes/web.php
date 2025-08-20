<?php

use App\Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('invite/register', Register::class)
    ->name('filament.invite.auth.register')
    ->middleware('signed')
    ->middleware('guest');
