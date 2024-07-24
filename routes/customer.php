<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Customer\{
    CustomerAddressController,
    LoginController,
    RegisterController,
    CustomerPageController,
    ResetPinController
};
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

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


//Send SMS Fazpass

if (env('APP_ENV') === 'local') {
    Route::get('/sms', [LandingController::class, 'sms']);
    Route::post('/send-sms', [LandingController::class, 'sms_send']);
    Route::get('/test_map', [LandingController::class, 'test_map']);
}
Route::middleware(['guest:customer'])->name('landing.')->group(function () {
    Route::get('/', [LandingController::class, 'index'])->name('index');
    Route::get('/amc-pasti', [LandingController::class, 'kelebihan_kami'])->name('kelebihan_kami');
    Route::get('/about', [LandingController::class, 'about'])->name('about');
    Route::get('/services', [LandingController::class, 'services'])->name('services');
    Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
    Route::get('/detailac/{qr}', [LandingController::class, 'showdetailac'])->name('showdetailac');
    Route::get('/detailac', [LandingController::class, 'detailac'])->name('detailac');
    Route::get('/term-and-condition', [LandingController::class, 'tnc'])->name('tnc');
    Route::get('/privacy-and-policy', [LandingController::class, 'policy'])->name('policy');
});
// dummy scan
Route::middleware(['guest:customer'])->name('customer.')->group(function () {
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/agent_register', [RegisterController::class, 'register_agent'])->name('agent_register');
    Route::post('/register', [RegisterController::class, 'store'])->name('store');

    Route::get('/view_otp/{customer}', [RegisterController::class, 'view_otp'])->name('view_otp');
    Route::post('/otp/{customer}', [RegisterController::class, 'otp'])->name('otp');
    Route::post('/resend_otp/{customer}', [RegisterController::class, 'resend_otp'])->name('resend_otp');

    Route::get('/view_check_otp/{customer}', [RegisterController::class, 'view_check_otp'])->name('view_check_otp');
    Route::post('/check_otp/{customer}', [RegisterController::class, 'check_otp'])->name('check_otp');

    Route::get('/view_pin/{customer}', [RegisterController::class, 'view_pin'])->name('view_pin');
    Route::post('/create_pin/{customer}', [RegisterController::class, 'create_pin'])->name('create_pin');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showlogin');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    //reset pin
    Route::get('/reset-pin', [ResetPinController::class, 'index'])->name('forgot.index');
    Route::post('/reset-pin', [ResetPinController::class, 'send_forgot'])->name('forgot.send_forgot');
    Route::get('/reset-pin/{token}', [ResetPinController::class, 'reset_pin'])->name('forgot.reset_pin');
    Route::post('/update-pin', [ResetPinController::class, 'update_pin'])->name('forgot.update_pin');

    // dummy

});
Route::post('/logout', [LoginController::class, 'logout'])->name('customer.logout');

Route::middleware(['auth:customer'])->prefix('customer/')->name('customer.')->group(function () {
    Route::get('/home', [CustomerPageController::class, 'index'])->name('index');
    Route::get('/create-order', [CustomerPageController::class, 'create_order'])->name('create_order');
    Route::get('/order-detail/{ordercustomer}', [CustomerPageController::class, 'order_detail'])->name('order_detail');
    Route::get('/list-order', [CustomerPageController::class, 'list_order'])->name('list_order');
    Route::get('/list-ac', [CustomerPageController::class, 'list_ac'])->name('list_ac');
    Route::post('/store-order', [CustomerPageController::class, 'store_order'])->name('store_order');
    Route::post('/store-address', [CustomerPageController::class, 'store_address'])->name('store_address');
    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::post('/get_service', [AjaxController::class, 'get_service'])->name('get_service');
        Route::post('/get_address_by_customer', [AjaxController::class, 'get_address_by_customer'])->name('get_address_by_customer');
        Route::post('/get_distance', [AjaxController::class, 'get_distance'])->name('get_distance');
    });
    Route::resource('/alamat', CustomerAddressController::class, [
        'parameters' => [
            'alamat' => 'cdata',
        ]
    ]);
    Route::get('/alamat/{dataqr}/detail_ac', [CustomerAddressController::class, 'detail_ac'])->name('alamat.detail_ac');
    Route::post('/alamat/{cdata}/utama', [CustomerAddressController::class, 'set_main'])->name('alamat.set_main');
    Route::get('/profile', [CustomerPageController::class, 'profile'])->name('profile.index');
    Route::get('/profile/change', [CustomerPageController::class, 'change_profile'])->name('profile.change');
    Route::post('/profile/change', [CustomerPageController::class, 'update_profile'])->name('profile.update');
    Route::get('/profile/pin_change', [CustomerPageController::class, 'change_pin'])->name('profile.pin');
    Route::post('/profile/pin_change', [CustomerPageController::class, 'update_pin'])->name('profile.update_pin');
    Route::post('/claim_warranty/{cdata}', [CustomerPageController::class, 'claim_warranty'])->name('claim_warranty');
});
