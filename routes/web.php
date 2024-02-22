<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Services\FirebaseService;
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

Route::get('/{any}', function () {
    return view('app'); // Ensure 'app' is your main entry blade file
})->where('any', '.*');

// Route::get('/live-queue', [App\Http\Controllers\TestController::class, 'showLiveQueue'])->name('live-queue');
Route::get('/login', function(){
    return view('login');
});

