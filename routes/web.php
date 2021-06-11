<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PayMayaController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AccomodationController;

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
	Route::get('register', [AuthController::class, 'register'])->name('register');
	Route::post('register-user', [AuthController::class, 'register_user'])->name('register_user');
	Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
	Route::get('admin/login', [AuthController::class, 'admin_login'])->name('admin_login');
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

	# Room
	Route::resource('rooms', RoomController::class);

	# Accomodation
	Route::resource('accomodation', AccomodationController::class);

	# Billing
	Route::resource('billing', BillingController::class);

	# Guest
	Route::get('guests', [GuestController::class, 'guests'])->name('guests');

	# Inquiries
	Route::resource('inquiries', InquiryController::class);

	# Reports
	Route::resource('reports', ReportsController::class);

	# Calendar
	Route::resource('calendar', CalendarController::class);

});

/*
|--------------------------------------------------------------------------
| Unauthenticated or Visitor routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['unauthenticated_or_visitor']], function(){
	# Homepage
	Route::get('guest/homepage', [HomepageController::class, 'guest_homepage'])->name('guest_homepage');

	# Guest
	Route::get('about', [GuestController::class, 'about'])->name('about');
	Route::get('contact', [GuestController::class, 'contact'])->name('contact');

	# Room
	Route::get('room/type/{accomodation_id}', [AccomodationController::class, 'room_type'])->name('room_type');
	Route::get('room', [AccomodationController::class, 'room'])->name('room');
});

/*
|--------------------------------------------------------------------------
| Visitor routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['visitor', 'auth']], function(){
	# Reservation
	Route::resource('reservation', ReservationController::class);
	Route::get('reservation/create/{id}', [ReservationController::class, 'create'])->name('reservation_create');
	Route::post('check-availability', [ReservationController::class, 'check_availability'])->name('check_availability');

	# Checkout
	# PayPal
	Route::post('checkout/api/paypal/order/create', [PayPalController::class, 'create_order'])->name('paypal.create_order');
	Route::post('checkout/api/paypal/order/capture/{order_id}', [PayPalController::class, 'capture_order'])->name('paypal.capture_order');
	# Stripe
	Route::post('checkout/api/stripe/order/create', [StripeController::class, 'create_order'])->name('stripe.create_order');
	# PayMaya
	Route::get('checkout/api/paymaya/order/create', [PayMayaController::class, 'create_order'])->name('paymaya.create_order');
	# Complete transaction
	Route::get('setup-completion', [ReservationController::class, 'setup_completion'])->name('setup_completion');
	Route::post('complete-transaction', [ReservationController::class, 'complete_transaction'])->name('complete_transaction');
	Route::get('transaction-invoice/{id}', [ReservationController::class, 'transaction_invoice'])->name('transaction_invoice');
	Route::get('print-invoice/{id}', [ReservationController::class, 'print_invoice'])->name('print_invoice');
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
