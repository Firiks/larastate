<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingImageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\RealtorListingAcceptOfferController;

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

// main listings
Route::get('/', [ListingController::class, 'index'])->name('listing.index');
Route::get('/listing/{listing}', [ListingController::class, 'show'])->name('listing.show');

// listing offers
Route::resource('listing.offer', ListingOfferController::class)->middleware('auth')->only(['store']);

// notifications
Route::resource('notification', NotificationController::class)->middleware('auth')->only(['index']);
Route::put('notification/{notification}/seen', NotificationSeenController::class )->middleware('auth')->name('notification.seen');

// auth
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

// user is redirected to this page if not verified
Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail'); // call the VerifyEmail file in resources/js/Pages/Auth/VerifyEmail.vue
})->middleware('auth')->name('verification.notice');

// send verification email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// verify email link - handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('listing.index')->with('success', 'Email was verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

// user account
Route::resource('user-account', UserAccountController::class)->only(['create', 'store']);

// realtor
Route::prefix('realtor')->name('realtor.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('listing', RealtorListingController::class)->withTrashed();
    Route::resource('listing.image', RealtorListingImageController::class)->only(['create', 'store', 'destroy']);
    Route::name('offer.accept')->put('offer/{offer}/accept',RealtorListingAcceptOfferController::class);
    Route::name('listing.restore')->put('listing/{listing}/restore',[RealtorListingController::class, 'restore'])->withTrashed();
});
