<?php

use App\Models\Listings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

//Common Resource Routes
//index - Show all listings
//show - Show single listings
//create - Show form to create new listing
//store - Store new listing
//edit - Show form to edit listing
//update - Update listing
//destroy - Delete listing

//Show all listings
Route::get('/', [ListingController::class, 'index']);

//Show Create Form
Route::get('/listing/create', [ListingController::class, 'create'])->middleware('auth');

//Store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show Edit page
Route::get('/listing/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Edit submit to update
Route::put('listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete listing data
Route::delete('listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

//Show single listing page
Route::get('/listing/{listing}', [ListingController::class, 'show']);

//Show register page
Route::get('/register', [UserController::class, 'register'])->middleware('guest');

//Create a new user and save the data in database
Route::post('/users', [UserController::class, 'store']);

//Logout the user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');


//Show the login page
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Login the user data
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


//Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage']);
