<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [RecipeController::class, 'getAllRecipe'])->name('home');

Route::middleware(['auth'])->group(function() {
    Route::post('/add-rating-review',[ReviewController::class,'add'])->name('add-rating'); 
    Route::get('profile-details',[HomeController::class,'profile'])->name('profile'); 
    Route::post('/set-profile',[HomeController::class,'setProfile'])->name('set.profile'); 

});  

Route::resource('recipes', RecipeController::class);
