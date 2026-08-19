<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContainerController;

Route::get('/', function () {
    return redirect()->route('clients.index');
});

Route::resource('clients', ClientController::class);
Route::resource('containers', ContainerController::class);
