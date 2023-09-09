<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//to show all listings
Route::get('/', [ListingController::class, 'index']);

//show create form 
Route::get('/listing/create', [ListingController::class, 'create'])->middleware('auth');

// store listings 
Route::post('/listing', [ListingController::class, 'store'])->middleware('auth');

//to show the edit form
Route::get('/listing/{listing}/edit', [ListingController::class, 'edit']) ->middleware('auth');

//update listing
Route::put('/listing/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete listing
Route::delete('/listing/{listing}', [ListingController::class, 'delete'])->middleware('auth');

//manage user listings
Route::get('/listing/manage', [ListingController::class, 'manage'])->middleware('auth');

//show a single listing
Route::get('/listing/{listing}', [ListingController::class, 'show']);

//show register/create user form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//create a new user
Route::post('/users', [UserController::class, 'store'])->middleware('guest');

//log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//show login form 
Route::get('/login', [UserController::class, 'login'])-> name('login')-> middleware('guest');

//log in the user
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->middleware('guest');




