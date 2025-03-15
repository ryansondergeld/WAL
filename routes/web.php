<?php

use App\Livewire\Game1P;
use App\Livewire\Game2P;
use App\Livewire\Home;
use App\Livewire\HowToPlay;
use App\Livewire\TestMode;
use App\Livewire\WinnersAndLosers;
use Illuminate\Support\Facades\Route;


# livewire Route
Route::get('/WinnersAndLosers', WinnersAndLosers::class);
Route::get('/Home', Home::class);
Route::get('/HowToPlay', HowToPlay::class);
Route::get('/Game1P', Game1P::class);
Route::get('/Game2P', Game2P::class);
Route::get('/TestMode', TestMode::class);
Route::get('/', Home::class);
