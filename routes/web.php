<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::auth.login')->name('login');
    Route::livewire('/register', 'pages::auth.register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/logout', 'pages::auth.logout')->name('logout');

    Route::prefix(config('price-today.administrator-route-prefix', 'admin'))->name('administrator.')->group(function () {
        Route::livewire('/', 'pages::administrator.dashboard.index')->name('dashboard');
        Route::livewire('/users', 'pages::administrator.user.index')->name('users');
        Route::livewire('/gold-platforms', 'pages::administrator.gold-platform.index')->name('gold-platforms');
    });
});
