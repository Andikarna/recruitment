<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/user',[LoginController::class, 'user']);