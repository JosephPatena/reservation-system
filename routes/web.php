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
use App\Http\Controllers\ProfileController;
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
	Route::post('check-password', [AuthController::class, 'check_password'])->name('check_password');
});

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['admin', 'auth']], function(){
	# Profile
	Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
	Route::post('update_profile', [ProfileController::class, 'update_profile'])->name('update_profile');
	

	# Homepage
	Route::get('admin/homepage', [HomepageController::class, 'admin_homepage'])->name('admin_homepage');

	# Room
	Route::resource('rooms', RoomController::class);
	Route::post('store-image', [RoomController::class, 'store_image'])->name('store_image');
	Route::post('delete-image', [RoomController::class, 'delete_image'])->name('delete_image');

	# Accomodation
	Route::resource('accomodation', AccomodationController::class);

	# Billing
	Route::resource('billing', BillingController::class);
	Route::post('enable_disable_billing', [BillingController::class, 'enable_disable_billing'])->name('enable_disable_billing');

	# Guest
	Route::get('guests', [GuestController::class, 'guests'])->name('guests');
	Route::get('restrict-user/{id}', [GuestController::class, 'restrict_user'])->name('restrict_user');
	Route::get('unrestrict-user/{id}', [GuestController::class, 'unrestrict_user'])->name('unrestrict_user');

	# Inquiries
	Route::resource('inquiries', InquiryController::class);

	# Reports
	Route::resource('reports', ReportsController::class);
	Route::get('reports/guest/{id}', [ReportsController::class, 'guest'])->name('guest');
	Route::get('reports/room/{id}', [ReportsController::class, 'room'])->name('room_reports');
	Route::get('reports-pdf', [ReportsController::class, 'pdf'])->name('reports_to_pdf');
	Route::get('reports-export', [ReportsController::class, 'export'])->name('reports_to_export');
	Route::post('reports/set-date-range', [ReportsController::class, 'set_date_range'])->name('set_date_range');

	# Calendar
	Route::resource('calendar', CalendarController::class);

	# Reservation
	Route::get('manage/reservation', [ReservationController::class, 'manage_reservation'])->name('manage_reservation');
	Route::post('set-status', [ReservationController::class, 'set_status'])->name('set_status');

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
	Route::get('room/type/{accomodation_id}', [RoomController::class, 'room_type'])->name('room_type');
	Route::get('room', [RoomController::class, 'room'])->name('room');
});

/*
|--------------------------------------------------------------------------
| Visitor routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['visitor', 'auth', 'restriction']], function(){
	# Reservation
	Route::resource('reservation', ReservationController::class);
	Route::get('reservation/create/{id}', [ReservationController::class, 'create'])->name('reservation_create');
	Route::post('check-availability', [ReservationController::class, 'check_availability'])->name('check_availability');

	# CHECKOUT #
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

	# Inquiries
	Route::get('my-inquiries', [InquiryController::class, 'my_inquiries'])->name('my_inquiries');
	Route::post('store-inquiry', [InquiryController::class, 'store_inquiry'])->name('store_inquiry');
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
