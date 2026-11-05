<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::guest.home.index')->name('guest.home.index');

Route::livewire('/check-url', 'pages::guest.check-url.index')->name('guest.check-url.index');

Route::livewire('/url-scan-history', 'pages::guest.url-scan-history.index')->name('guest.url-scan-history.index');

Route::livewire('/url-report', 'pages::guest.url-report.index')->name('guest.url-report.index');
Route::livewire('/url-report/create', 'pages::guest.url-report.create')->name('guest.url-report.create');
Route::livewire('/url-report/{id}/show', 'pages::guest.url-report.show')->name('guest.url-report.show');

Route::livewire('/about', 'pages::guest.about.index')->name('guest.about.index');

Route::livewire('/threat/{type}/show', 'pages::guest.threat.show')
    ->name('guest.threat.show');

Route::livewire(
    '/insight/{slug}',
    'pages::guest.insight.show'
)->name('guest.insight.show');
