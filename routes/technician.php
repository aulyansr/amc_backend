<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Teknisi\{
    TechnicianPageController,
    TeknisiLoginController
};
use Illuminate\Support\Facades\Route;



Route::middleware(['guest:technician'])->name('technician.')->group(function () {
    Route::get('/login', [TeknisiLoginController::class, 'showLoginForm'])->name('login.index');
    Route::post('/login', [TeknisiLoginController::class, 'login'])->name('login.submit');
});
Route::middleware(['auth:technician'])->name('technician.')->group(function () {
    // Technician routes here
    Route::get('/home', [TechnicianPageController::class, 'index'])->name('home');
    Route::put('/home/{id}/status_order', [TechnicianPageController::class, 'status_order'])->name('status_order');
    Route::get('/detail', [TechnicianPageController::class, 'index'])->name('detail');
    Route::get('/qr', [TechnicianPageController::class, 'qr'])->name('qr');
    Route::get('/qr/{qr}/edit', [TechnicianPageController::class, 'qr_edit'])->name('qr_edit');
    Route::get('/detail-ac/{order}/{ac}', [TechnicianPageController::class, 'detail_ac_order'])->name('detail_ac_order');
    Route::get('/ac/{order}/add_detail_ac', [TechnicianPageController::class, 'add_detail_ac'])->name('add_detail_ac');
    Route::post('/ac/{order}/post', [TechnicianPageController::class, 'store_detail_ac'])->name('store_detail_ac');
    Route::get('/orders', [TechnicianPageController::class, 'orders'])->name('orders');
    Route::get('/profile', [TechnicianPageController::class, 'profile'])->name('profile');
    Route::get('/orders/{id}', [TechnicianPageController::class, 'orderDetail'])->name('orderDetail');
    Route::post('/store_service/{qr}/post', [TechnicianPageController::class, 'store_service'])->name('store_service');
    Route::post('/upload_work_order/{id}/post', [TechnicianPageController::class, 'upload_work_order'])->name('upload_work_order');
    Route::get('/select-repair-type', [TechnicianPageController::class, 'select_repair_type'])->name('select_repair_type');
    Route::get('/create-repair-document', [TechnicianPageController::class, 'create_repair_document'])->name('create_repair_document');

    Route::post('/store-repair-document', [TechnicianPageController::class, 'store_repair_document'])->name('store_repair_document');
    Route::get('/show-repair-document/{id}', [TechnicianPageController::class, 'show_repair_document'])->name('show_repair_document');
    Route::get('/edit-repair-document/{id}', [TechnicianPageController::class, 'edit_repair_document'])->name('edit_repair_document');
    Route::put('/update-repair-document/{id}', [TechnicianPageController::class, 'update_repair_document'])->name('update_repair_document');
    Route::post('/update-order-status/{id}', [TechnicianPageController::class, 'updateOrderStatus'])->name('updateOrderStatus');
    Route::get('/detail_ac', [TechnicianPageController::class, 'detail_ac'])->name('detail_ac');
    Route::post('/logout', [TeknisiLoginController::class, 'logout'])->name('logout');

    Route::post('/pending-order/{id}', [TechnicianPageController::class, 'pending_order'])->name('pending_order');
    Route::get('/edit-order/{id}', [TechnicianPageController::class, 'edit_order'])->name('edit_order');
    Route::post('/update-order/{id}', [TechnicianPageController::class, 'update_order'])->name('update_order');
    Route::post('/check-in/{id}', [TechnicianPageController::class, 'check_in'])->name('check_in');
    Route::post('/update-start-work/{id}', [TechnicianPageController::class, 'update_start_work'])->name('update_start_work');
    Route::get('/add-service-ac/{order}/{qr}', [TechnicianPageController::class, 'add_service_ac'])->name('add_service_ac');
    Route::post ('/store-service-ac/{order}/{qr}', [TechnicianPageController::class, 'store_service_ac'])->name('store_service_ac');
    Route::get('/upload-image-before-execute/{order}/{qr}', [TechnicianPageController::class, 'upload_image_before'])->name('upload_image_before');
    Route::post('/store-image-before-execute/{id}/{image_id}', [TechnicianPageController::class, 'store_image_before'])->name('store_image_before');
    Route::get('/show-image/{order}/{qr}', [TechnicianPageController::class, 'view_image_before'])->name('view_image_before');
    Route::get('/update-list-service/{order}/{qr}', [TechnicianPageController::class, 'update_service'])->name('update_service');
    Route::get('/upload-image-after-execute/{order}/{qr}', [TechnicianPageController::class, 'upload_image_after'])->name('upload_image_after');
    Route::post('/store-image-after-execute/{id}/{image_id}', [TechnicianPageController::class, 'store_image_after'])->name('store_image_after');
    Route::post('/upload-location-image/{id}', [TechnicianPageController::class, 'upload_location_image'])->name('upload_location_image');

    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::post('/get_customer', [AjaxController::class, 'get_customer'])->name('get_customer');
        Route::post('/get_address_by_customer', [AjaxController::class, 'get_address_by_customer'])->name('get_address_by_customer');
        Route::post('/get_service_counts', [AjaxController::class, 'get_service_counts'])->name('get_service_counts');
    });
});
