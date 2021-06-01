<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BooknowController;
use App\Http\Controllers\HomepageController;

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

/*
|--------------------------------------------------------------------------
| Redirect homepage
|--------------------------------------------------------------------------
*/
Route::get('/', function(){
	if (Auth::check() && Auth::user()->role_id == 1)
	{
		return redirect()->route('admin_homepage');
	}
	return redirect()->route('guest_homepage');
});

/*
|--------------------------------------------------------------------------
| Unauthenticated routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'guest'], function(){
	Route::get('login', [AuthController::class, 'login'])->name('login');
	Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function(){
	Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['admin', 'auth']], function(){
	# Homepage
	Route::get('admin/homepage', [HomepageController::class, 'admin_homepage'])->name('admin_homepage');
});

/*
|--------------------------------------------------------------------------
| Unauthenticated or Visitor routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['unauthenticated_or_visitor']], function(){
	# Homepage
	Route::get('guest/homepage', [HomepageController::class, 'guest_homepage'])->name('guest_homepage');

	# Room
	Route::resource('room', RoomController::class);

	# Guest
	Route::resource('guest', GuestController::class);
	Route::get('about', [GuestController::class, 'about'])->name('about');
	Route::get('contact', [GuestController::class, 'contact'])->name('contact');
});

/*
|--------------------------------------------------------------------------
| Visitor routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['visitor', 'auth']], function(){
	# Booknow
	Route::resource('booknow', BooknowController::class);
});

/*
|--------------------------------------------------------------------------
| Unauthorized
|--------------------------------------------------------------------------
*/
Route::get('unauthorized', function(){
	if (Auth::user()->role_id == 1)
	{
		return view('admin.401');
	}
	if (Auth::user()->role_id == 2)
	{
		return view('guest.401');
	}
})->name('unauthorized');
