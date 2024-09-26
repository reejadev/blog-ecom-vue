<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

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



Route::get('/', [HomeController::class,'homepage']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class,'index'])->middleware('auth')->name('home');

Route::get('/run-migration',function(){
    Artisan::call('optimize:clear');
    Artisan::call('migrate:refresh--seed');

    return "Migrations executed successfully";
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
Route::get('/post_page', [AdminController::class,'post_page']);

Route::post('/add_post', [AdminController::class,'addpost']);

Route::get('/show_page', [AdminController::class,'show_page']);

Route::get('/deletemenu/{id}', [AdminController::class,'deletemenu']);

Route::get('/edit_page/{id}', [AdminController::class,'edit_page']);

Route::post('/update_post/{id}', [AdminController::class,'update_post']);

Route::get('/desc_page/{id}', [HomeController::class,'desc_page']);

Route::get('/create_post', [HomeController::class,'create_post'])->middleware('auth');

Route::get('/timeline/{RahulGandhi}', [APIController::class, 'userTimeline']);

Route::post('/user_post', [HomeController::class,'user_post'])->middleware('auth');

Route::get('/my_post', [HomeController::class,'my_post'])->middleware('auth');

Route::get('/edit_page/{id}', [HomeController::class,'edit_page']);

Route::post('/update_post/{id}', [HomeController::class,'update_post']);

Route::get('/deletemenu/{id}', [HomeController::class,'deletemenu']);

Route::get('/accept_post/{id}', [AdminController::class,'accept_post']);

Route::get('/reject_post/{id}', [AdminController::class,'reject_post']);

Route::get('/search', [HomeController::class,'search'])->name('search');
