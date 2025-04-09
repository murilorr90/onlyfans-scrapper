<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Profile;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});


Route::view('/search', 'search-profiles');
Route::get('/api/search', [ProfileController::class, 'search']);
Route::get('/api/scrape', [ProfileController::class, 'scrape']);

