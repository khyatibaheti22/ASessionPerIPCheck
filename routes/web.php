<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;


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

Route::middleware(['throttle:ip'])->group(function(){
    Route::get('/test2',[TestController::class,'index2']);
});
Route::middleware('session.rate_limiter')->group(function(){
    Route::match(['get','post'],'/test',[TestController::class,'index']);
});
// Route::get('/test',[TestController::class,'index']);
Route::get('/', function () {
    return view('welcome');
});
