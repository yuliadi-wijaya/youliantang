<?php

use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\InvoiceSettingController;
use App\Http\Controllers\RazorpayPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePaymentController;

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

Route::get('/', 'HomeController@index');
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// authentication routes
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::post('logout', 'Auth\AuthController@logout');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');
Route::get('register', 'Auth\AuthController@showRegistrationForm');
Route::post('register', 'Auth\AuthController@register');

Route::get('app-setting', [AppSettingController::class, 'index']);
Route::post('update-setting', [AppSettingController::class, 'update'])->name('update-setting');

Route::get('invoice-setting', [InvoiceSettingController::class, 'index']);
Route::post('update-invoice-setting', [InvoiceSettingController::class, 'update'])->name('update-invoice-setting');

Route::get('forgot-password', 'Auth\AuthController@showForgotPasswordForm');
Route::post('forgot-password', 'Auth\AuthController@forgotPassword');
Route::get('reset-password/{user_id}/{token}', 'Auth\AuthController@showResetPasswordForm');
Route::post('reset-password', 'Auth\AuthController@resetPassword');
Route::get('change-password', 'Auth\AuthController@showChangePasswordForm');
Route::post('change-password', 'Auth\AuthController@changePassword');

Route::middleware('sentinel.auth')->group(function () {
// profile routes
Route::get('profile-edit', 'UserController@edit');
Route::post('profile-update', 'UserController@update');
Route::get('profile-view', 'UserController@profile_view');

// resource routes
Route::get('user/profile-details', 'UserController@userProfileDetails');
Route::resource('user', 'UserController');
Route::resource('therapist', 'TherapistController');
Route::get('therapist-view/{id}', 'TherapistController@therapist_view');
Route::resource('customer', 'CustomerController');
Route::resource('receptionist', 'ReceptionistController');
Route::get('receptionist-view/{id}', 'ReceptionistController@receptionist_view');
Route::resource('appointment', 'AppointmentController');
Route::resource('prescription', 'PrescriptionController');
Route::resource('invoice', 'InvoiceController');
Route::resource('membership', 'MembershipController');
Route::resource('customermember', 'CustomerMemberController');
Route::resource('product', 'ProductController');
Route::resource('room', 'RoomController');
Route::resource('promo', 'PromoController');
Route::resource('transaction', 'TransactionController');
Route::resource('review', 'ReviewController');

// appointment routes
Route::get('appointmentList', 'AppointmentController@appointment_list');
Route::post('appointment-status/{id}', 'AppointmentController@appointment_status');
Route::get('getMonthlyAppointments', 'ReportController@getMonthlyAppointments');
Route::post('customer-by-appointment', 'InvoiceController@customer_by_appointment')->name('customer_by_appointment');
Route::post('appointment-by-therapist', 'InvoiceController@appointment_by_therapist')->name('appointment_by_therapist');
Route::post('therapist-availability', 'InvoiceController@therapist_availability')->name('therapist_availability');

Route::post('/therapist-by-day-time', 'AppointmentController@therapist_by_day_time')->name('therapist_by_day_time');
Route::post('/appointment-time-by-appointment-slot', 'AppointmentController@time_by_slot')->name('timeBySlot');
Route::get('appointment-create', 'AppointmentController@appointment_create');
Route::post('appointment-store', 'AppointmentController@appointment_store');
Route::get('/cal-appointment-show', 'AppointmentController@cal_appointment_show');
Route::get('pending-appointment', 'AppointmentController@pending_appointment');
Route::get('upcoming-appointment', 'AppointmentController@upcoming_appointment');
Route::get('complete-appointment', 'AppointmentController@complete_appointment');
Route::get('cancel-appointment', 'AppointmentController@cancel_appointment');
Route::get('today-appointment', 'AppointmentController@today_appointment');
Route::get('customer-appointment', 'AppointmentController@customer_appointment');

// Revenue / Earning / calender
Route::get('getMonthlyUsersRevenue', 'ReportController@getMonthlyUsersRevenue');
Route::get('getMonthlyInvoicesRevenue', 'ReportController@getMonthlyInvoicesRevenue');
Route::get('getYearlyInvoicesRevenue', 'ReportController@getYearlyInvoicesRevenue');
Route::get('getMonthlyEarning', 'ReportController@getMonthlyEarning');
Route::get('analytics', 'ReportController@analytics');
Route::get('calender', 'HomeController@calender');

// Notification routes
Route::get('notification-list', 'NotificationController@index');
Route::get('/notification/{id}', 'NotificationController@notification');
Route::post('/top-notification', 'NotificationController@notification_top');
Route::get('/notification-count', 'NotificationController@notificationCount');

// Time slot
Route::get('/time-edit/{id}', 'TherapistController@time_edit');
Route::post('/time-update/{id}', 'TherapistController@time_update');
Route::get('/time-update-ajax/{id}', 'TherapistController@time_update_ajax');

// Invoice routes
Route::get('invoice-email/{id}', 'EmailController@invoice_email_send');
Route::get('invoice-list', 'InvoiceController@invoice_list');
Route::get('invoice-view/{id}', 'InvoiceController@invoice_view');
Route::get('invoice-pdf/{id}', 'InvoiceController@invoice_pdf');
// Route::get('transaction', 'InvoiceController@transaction');

Route::get('invoice-customer-create', 'CustomerController@create_from_invoice');

//Transaction routes

// Prescription routes
Route::get('prescription-email/{id}', 'EmailController@prescription_email_send');
Route::get('prescription-list', 'PrescriptionController@prescription_list');
Route::get('prescription-view/{id}', 'PrescriptionController@prescription_view');

// Pagination
Route::post('per-page-item', 'HomeController@per_page_item');

// Razorpay Payment
Route::post('payment-complete', [RazorpayPaymentController::class, 'payment_complete']);
Route::post('razorpay-payment/{id}', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');

//Stripe Payment
Route::post('stripe/{id}', [StripePaymentController::class, 'store'])->name('stripe.store');
Route::get('paymentComplete', [StripePaymentController::class, 'payment_complete']);

// Payment Api key add
Route::resource('payment-key','PaymentApiController');

//Report Customer Registration
Route::get('/rf-customer-reg', 'ReportCustomerController@fiterReportReg');
Route::get('/rs-customer-reg', 'ReportCustomerController@showReportCustomerReg')->name('rs-customer-reg');
Route::get('/ex-customer-reg', 'ReportCustomerController@exportReportCustomerReg')->name('ex-customer-reg');

// Report Customer Transaction
Route::get('/rf-customer-trans', 'ReportCustomerController@fiterReportTrans');
Route::get('/rs-customer-trans', 'ReportCustomerController@showReportCustomerTrans')->name('rs-customer-trans');
Route::get('/ex-customer-trans', 'ReportCustomerController@exportReportCustomerTrans')->name('ex-customer-trans');

// Report Therapist Total
Route::get('/rf-therapist-total', 'ReportTherapistController@fiterReportTotal');
Route::get('/rs-therapist-total', 'ReportTherapistController@showReportTherapistTotal')->name('rs-therapist-total');
Route::get('/ex-therapist-total', 'ReportTherapistController@exportReportTherapistTotal')->name('ex-therapist-total');

// Report Therapist Trans
Route::get('/rf-therapist-trans', 'ReportTherapistController@fiterReportTrans');
Route::get('/rs-therapist-trans', 'ReportTherapistController@showReportTherapistTrans')->name('rs-therapist-trans');
Route::get('/ex-therapist-trans', 'ReportTherapistController@exportReportTherapistTrans')->name('ex-therapist-trans');

// Report Trans
Route::get('/rf-trans', 'ReportTransController@fiterReportTrans');
Route::get('/rs-trans', 'ReportTransController@showReportTrans')->name('rs-trans');
Route::get('/ex-trans', 'ReportTransController@exportReportTrans')->name('ex-trans');
Route::get('transactions-revenue-report', 'ReportController@TransactionRevenueReport');
Route::get('transactions-commission-fee-report', 'ReportController@TransactionCommissionFeeReport');
Route::get('therapist-commission-fee-report', 'ReportController@TherapistCommissionFeeReport');
Route::get('therapist-review-report', 'ReportController@TherapistReviewReport');
Route::get('customer-new-and-repeat-order-report', 'ReportController@CustomerNewAndRepeatOrderReport');

});
