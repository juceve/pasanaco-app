<?php

use App\Livewire\GroupCrud;
use App\Livewire\GroupSettings;
use App\Livewire\ParticipantsCrud;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/participants', ParticipantsCrud::class)->name('participants');
    Route::get('/groups', GroupCrud::class)->name('groups');
    Route::get('/groups/{groupId}/settings', GroupSettings::class)->name('groups.settings');
});
