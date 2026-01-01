<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntrianController;

Route::get('/antrian/status', [AntrianController::class, 'status']);
