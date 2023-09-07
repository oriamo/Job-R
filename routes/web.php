<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
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
Route::get('/listing/create', [ListingController::class, 'create']);

//show create form 
Route::post('/listing', [ListingController::class, 'store']);

//show a single listing
Route::get('/listing/{listing}', [ListingController::class, 'show']);