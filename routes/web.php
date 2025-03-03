<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;


# livewire Route
Route::get('/Home', Home::class);
Route::get('/', Home::class);
