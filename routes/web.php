<?php

use App\Facades\ProductRepo;
use App\Facades\PS;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
