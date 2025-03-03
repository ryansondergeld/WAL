<?php

use App\Livewire\WinnersAndLosers;
use Illuminate\Support\Facades\Route;


# livewire Route
Route::get('/WinnersAndLosers', WinnersAndLosers::class);
Route::get('/', WinnersAndLosers::class);
