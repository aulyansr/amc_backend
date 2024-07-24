<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Order\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{
    PermissionController,
    RoleController,
    TechniciansController,
    UserController,
};
use App\Http\Controllers\Master\{
    BranchesController,
    MasterCustomerController,
    MasterAcController,
    MasterQrController,
    MasterAddressController,
    Master_skillsController,
    ServiceCorporateController,
    ServicesController,
    ServicesGroupController,
    ServicesTypeController,
    ShiftsController,
    TeamsController,
    MasterTransportFeeController,
    Technician_levelsController,
    CustomerB2b2cController,
    RepairAttachmentController,
    RepairAttachmentItemController,
    SparePartGroupController,
    SparePartController,
    ChildServiceController,
    ServiceChildrenController,
    ServiceSparePartController,
};
use App\Http\Controllers\Order\OrdersController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\SettingController;
use App\Models\MasterTransportFee;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/get_kota', [AjaxController::class, 'get_kota'])->name('get.kota');
Route::get('/get_kecamatan', [AjaxController::class, 'get_kecamatan'])->name('get.kecamatan');
Route::get('/get_kelurahan', [AjaxController::class, 'get_kelurahan'])->name('get.kelurahan');


Auth::routes([
    'register' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::prefix('account')->group(function () {
        Route::resource('/roles', RoleController::class);
        Route::resource('/users', UserController::class);
        Route::resource('/permissions', PermissionController::class);
        Route::resource('/technicians', TechniciansController::class);
        Route::resource('/customers', MasterCustomerController::class, [
            'parameters' => [
                'customers' => 'masterCustomer'
            ]
        ]);
        Route::get('/customers/{masterCustomer}/view_pin', [MasterCustomerController::class, 'view_pin'])->name('customers.view_pin');
        Route::put('/customers/{masterCustomer}/update_pin', [MasterCustomerController::class, 'update_pin'])->name('customers.update_pin');
        Route::post('/customers/{masterCustomer}/invoice_customer', [MasterCustomerController::class, 'invoice_customer'])->name('customers.invoice_customer');
        Route::resource('/customers.address', MasterAddressController::class, [
            'parameters' => [
                'address' => 'masterAddress',
                'customers' => 'masterCustomer',
            ]
        ]);
        Route::post('/customers/{masterCustomer}/excel_invoice', [MasterCustomerController::class, 'export_invoice'])->name('customers.excel_invoice');
        Route::resource('/customers.service_corporate', ServiceCorporateController::class, [
            'parameters' => [
                'service_corporate' => 'serviceCorporate',
                'customers' => 'masterCustomer',
            ]
        ])->except('index', 'show');
        Route::post('customers/{masterCustomer}/service_corporate/{service}/duplicate', [ServiceCorporateController::class, 'duplicate'])->name('customers.service_corporate.duplicate');
        Route::resource('/customers.customer_b2b2c', CustomerB2b2cController::class, [
            'parameters' => [
                'customer_b2b2c' => 'data',
                'customers' => 'partner',
            ]
        ])->except('index', 'show');
    });
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('/branch', BranchesController::class);
        Route::resource('/shifts', ShiftsController::class);
        Route::resource('/technician_levels', Technician_levelsController::class);
        Route::resource('/services', ServicesController::class);
        Route::post('/services/{services}/duplicate', [ServicesController::class, 'duplicate'])->name('services.duplicate');
        Route::resource('/services_group', ServicesGroupController::class);
        Route::resource('/services_type', ServicesTypeController::class);
        Route::resource('/teams', TeamsController::class);
        Route::resource('/master_skills', Master_skillsController::class);
        Route::resource('/masterac', MasterAcController::class);
        Route::resource('/qrgenerate', MasterQrController::class);
        Route::resource('/paket', PaketController::class);
        Route::resource('/promos', PromoController::class);
        Route::resource('/transport_fee', MasterTransportFeeController::class);
        Route::resource('/repair_attachment', RepairAttachmentController::class);
        Route::resource('/repair_attachment_item', RepairAttachmentItemController::class);

        Route::get('/qrgenerate/{qrgenerate}/pdf', [MasterQrController::class, 'generatepdf'])->name('qrgenerate.generatepdf');
        Route::resource('/spare_part_group', SparePartGroupController::class);
        Route::resource('/spare_part', SparePartController::class);
        Route::resource('/child_service', ChildServiceController::class);
        Route::resource('/services.service_children', ServiceChildrenController::class, [
            'parameters' => [
                'services' => 'service',
                'service_children' => 'service_children',
            ]
        ])->except('index', 'show');
        Route::resource('/services.service_spare_part', ServiceSparePartController::class, [
            'parameters' => [
                'services' => 'service',
                'service_spare_part' => 'service_spare_part',
            ]
        ])->except('index', 'show');
    });

    Route::resource('/orders', OrdersController::class);
    Route::get('/warranty_orders', [OrdersController::class, 'warranty_orders'])->name('orders.warranty_orders');
    Route::put('/warranty_orders/{orders}/warranty', [OrdersController::class, 'confirm_warranty_orders'])->name('orders.confirm_warranty_orders');
    Route::resource('/subscription', SubscriptionController::class);
    Route::put('/orders/{orders}/payment', [OrdersController::class, 'payment'])->name('orders.payment');
    Route::put('/orders/{orders}/assignteam', [OrdersController::class, 'assignteam'])->name('orders.assignteam');
    Route::put('/orders/{orders}/deleteassignteam', [OrdersController::class, 'deleteassignteam'])->name('orders.deleteassignteam');
    Route::put('/orders/{orders}/completedorder', [OrdersController::class, 'completedorder'])->name('orders.completedorder');
    Route::put('/orders/{orders}/completedpayment', [OrdersController::class, 'completedpayment'])->name('orders.completedpayment');
    Route::get('/orders/{orders}/invoice', [OrdersController::class, 'invoice'])->name('orders.invoice');
    Route::get('/orders/report/orders', [OrdersController::class, 'report_order'])->name('orders.report_order');
    Route::get('/orders/{orders}/revision', [OrdersController::class, 'revision'])->name('orders.revision');
    Route::put('/orders/{orders}/revisionupdate', [OrdersController::class, 'revisionupdate'])->name('orders.revisionupdate');
    Route::put('/orders/{orders}/canceled_order', [OrdersController::class, 'canceled_order'])->name('orders.canceled_order');
    Route::post('/orders/{orders}/upload_work_order', [OrdersController::class, 'upload_work_order'])->name('orders.upload_work_order');
    Route::post('/orders/{orders}/upload_work_order_doc', [OrdersController::class, 'upload_work_order_doc'])->name('orders.upload_work_order_doc');
    Route::get('/orders/{orders}/spk_pdf', [OrdersController::class, 'spk_pdf'])->name('orders.spk_pdf');

    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::post('/get_customer', [AjaxController::class, 'get_customer'])->name('get_customer');
        Route::post('/get_service', [AjaxController::class, 'get_service'])->name('get_service');
        Route::post('/get_address_by_customer', [AjaxController::class, 'get_address_by_customer'])->name('get_address_by_customer');
        Route::post('/get_teams_available', [AjaxController::class, 'get_teams_available'])->name('get_teams_available');
        Route::post('/get_customer_subscription', [AjaxController::class, 'get_customer_subscription'])->name('get_customer_subscription');
        Route::get('/get_count_distance', [AjaxController::class, 'get_count_distance'])->name('get_count_distance');
        Route::get('/get_schedule_order_resource', [AjaxController::class, 'get_schedule_order_resource'])->name('get_schedule_order_resource');
        Route::get('/get_schedule_order_event', [AjaxController::class, 'get_schedule_order_event'])->name('get_schedule_order_event');
        Route::get('/get_schedule_order_by_customer/{id}', [AjaxController::class, 'get_schedule_order_by_customer'])->name('get_schedule_order_by_customer');
        Route::post('/get_service_group', [AjaxController::class, 'get_service_group'])->name('get_service_group');
        Route::post('/get_customer_b2b2c', [AjaxController::class, 'get_customer_b2b2c'])->name('get_customer_b2b2c');
        Route::get('/get_service_spare_part',[AjaxController::class, 'get_service_spare_part'])->name('get_service_spare_part');
    });


    // Setting
    Route::get('/setting/', [SettingController::class, 'edit'])->name('setting.edit');
    Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
});
