<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::front.gold-platform.index')->name('home');
Route::livewire('/platforms/{slug}', 'pages::front.gold-platform.view')->name('gold-platforms.view');

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::auth.login')->name('login');
    Route::livewire('/register', 'pages::auth.register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/logout', 'pages::auth.logout')->name('logout');

    Route::prefix('account')->name('user.')->group(function () {
        Route::livewire('/', 'pages::user.dashboard.index')->name('dashboard');
        Route::livewire('/change-password', 'pages::user.dashboard.change-password')->name('change-password');
        Route::livewire('/change-email', 'pages::user.dashboard.change-email')->name('change-email');
        Route::livewire('/change-mobile', 'pages::user.dashboard.change-mobile')->name('change-mobile');
    });

    Route::prefix(config('price-today.administrator-route-prefix', 'admin'))->name('administrator.')->group(function () {
        Route::livewire('/', 'pages::administrator.dashboard.index')->name('dashboard');
        Route::livewire('/users', 'pages::administrator.user.index')->name('users');
        Route::livewire('/gold-platforms', 'pages::administrator.gold-platform.index')->name('gold-platforms');
    });
});
