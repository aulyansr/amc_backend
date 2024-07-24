<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Enums\SubscriptionStatus;
use App\Exports\Document;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Http\Requests\OrderRequest;
use App\Models\AcCustomer;
use App\Models\Branch;
use App\Models\MasterAc;
use App\Models\MasterAddress;
use App\Models\MasterCustomer;
use App\Models\MasterQr;
use App\Models\OrderDetail;
use App\Models\OrderDetailAttachment;
use App\Models\OrderDetailHistory;
use App\Models\OrderSparePartDetail;
use App\Models\OrderHistory;
use App\Models\Service;
use App\Models\ServicesGroup;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Team;
use App\Models\TechnicianCommission;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Sabberworm\CSS\Settings;
use DataTables;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Illuminate\Support\Facades\File;

class OrdersController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:orders-list|orders-create|orders-edit|orders-delete|orders-payment|orders-assignteam|orders-revision', ['only' => ['index', 'show']]);
        $this->middleware('permission:orders-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:orders-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:orders-delete', ['only' => ['destroy']]);
        $this->middleware('permission:orders-payment', ['only' => ['payment']]);
        $this->middleware('permission:orders-assignteam', ['only' => ['assignteam']]);
        $this->middleware('permission:orders-deleteassignteam', ['only' => ['deleteassignteam']]);
        $this->middleware('permission:orders-completedorder', ['only' => ['completedorder']]);
        $this->middleware('permission:orders-invoice', ['only' => ['invoice']]);
        $this->middleware('permission:orders-revision', ['only' => ['revision', 'revisionupdate']]);
        $this->middleware('permission:orders-workorder', ['only' => ['upload_work_order']]);
        $this->middleware('permission:orders-workorder', ['only' => ['upload_work_order_doc']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Get the search term, order status, and booked date from the request
        $searchTerm = $request->input('searchFilter');
        $orderStatus = $request->input('order_status');
        $paymentStatus = $request->input('payment_status');
        $bookedDate = $request->input('booked_date');
        $button_status = $request->input('button_status');
        $statusorder = OrderStatus::getDescriptionArray();
        // $statusorderFilter = OrderStatus::getShortFilterArray();

        if ($request->ajax()) {
            $start_table = $request->input('start');
            $length_table = $request->input('length');
            $query = Order::with('customer', 'address', 'branch', 'order_details')->orderBy('booked_date', 'desc');

            if ($searchTerm) {
                $query->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->whereHas('customer', function ($query) use ($searchTerm) {
                        $query->where('nama', 'LIKE', '%' . $searchTerm . '%');
                    })->orWhere('order_code', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('ref_no', 'LIKE', '%' . $searchTerm . '%');
                });
            }
            if ($orderStatus) {
                if (in_array($orderStatus, [2, 3, 4, 5])) {
                    $query->whereIn('order_status', [2, 3, 4, 5]);
                } else {
                    $query->where('order_status', $orderStatus);
                }
            }
            if ($paymentStatus) {
                $query->where('payment_status', $paymentStatus);
            }

            if ($bookedDate) {
                $dates = explode(" - ", $bookedDate);

                $startDate = date('Y-m-d', strtotime($dates[0]));
                $endDate = date('Y-m-d', strtotime($dates[1]));
                if ($startDate != $endDate) {
                    $query->whereDate('booked_date', '>=', $startDate)
                        ->whereDate('booked_date', '<=', date('Y-m-d H:i:s', strtotime($endDate . " 23:59:59")));
                }
            }
            $query->where('is_warranty', 0);
            // $query->skip($start_table)->take($length_table)->get();
            $orders = $query->get();
            // $orders->each(function ($order) {
            //     $order->serviceCounts = $order->getServiceCountsAttribute();
            // });
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('tanggal_booking', function ($row) {
                    return date('D, d-F-Y / H:i', strtotime($row->booked_date));
                })
                ->addColumn('order_code', function ($row) {
                    return $row->order_code;
                })
                ->addColumn('ref_no', function ($row) {
                    return $row->ref_no;
                })
                ->addColumn('customer', function ($row) {
                    $customer = $row->customer?->type == '2' ? $row->customer_b2b2c?->nama . ' - ' . $row->customer->nama : $row->customer?->nama;
                    $alamat = optional($row->address)->address_name ?? 'tidak ada alamat';
                    return $customer . ' - ' . $alamat;
                })
                ->addColumn('status', function ($row) use ($statusorder) {
                    $status = "<span class='" . $statusorder[$row->order_status][1] . "'>{$statusorder[$row->order_status][0]}</span>";
                    return $status;
                })
                ->addColumn('actions', function ($row) {
                    $html = '<div class="d-flex gap-2">';
                    $html .= '<a href="' . route('orders.show', [$row->id]) . '" class="btn btn-info">Show</a>';

                    if ($row->order_status != 0) {
                        if (Auth::user()->can('orders-invoice')) {
                            $html .= '<a href="' . route('orders.invoice', $row->id) . '" class="btn btn-secondary">Invoice</a>';
                        }
                    }

                    if (($row->order_status > 0 && $row->order_status < 2) || $row->order_status == 6) {
                        if (auth()->user()->can('orders-edit')) {
                            $html .= '<a href="' . route('orders.edit', [$row->id]) . '" class="btn btn-primary">Edit</a>';
                        }
                        if (auth()->user()->can('orders-delete')) {
                            $html .= '<form method="POST" action="' . route("orders.destroy", $row->id) . '" onsubmit="return deleteData()" style="display:inline">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                  </form>';
                        }
                    } elseif ($row->order_status >= 2 && $row->order_status < 6) {
                        if (auth()->user()->can('orders-revision')) {
                            $html .= '<a href="' . route('orders.revision', [$row->id]) . '" class="btn btn-primary">Revisi</a>';
                        }
                        if (auth()->user()->can('orders-canceled')) {
                            $html .= '<button type="button" data-bs-route="' . route('orders.canceled_order', $row->id) . '" data-bs-canceledorder="' . $row->id . '" class="btn btn-danger cancel-order">Cancel</button>';
                        }
                    }

                    $html .= '</div>';
                    return $html;
                })->rawColumns(['status', 'actions'])
                ->toJson();
        } else if ($button_status == 'search' || empty($button_status)) {
            // Query the orders based on the filter parameters

            $data = [
                'array_status' => OrderStatus::getShortFilterArray(),
                'statusPayment' => OrderStatus::getPaymentStatus(),
                'filter' => [
                    'search' => $searchTerm,
                    'order_status' => $orderStatus,
                    'booked_date' => $bookedDate,
                    'payment_status' => $paymentStatus
                ],
            ];

            return view('orders.index_optimize', $data);
        } elseif ($button_status == 'download_old') {
            $collection = [];

            $heading = [
                'Nama Customer',
                'Store',
                'Area',
                'status',
                'split',
                'stand',
                'cassete',
                'central',
                'tanggal',
                'jam',
                'jenis servis',
                'Teknisi',
                '@Rp Biaya Servis',
                'Diskon',
                'Total Biaya Rp',
            ];
            $dates = explode(" - ", $request->booked_date);
            $startDate = date('Y-m-d', strtotime($dates[0]));
            $endDate = date('Y-m-d', strtotime($dates[1]));
            $orders = Order::whereBetween('booked_date', [$startDate, date('Y-m-d H:i:s', strtotime($endDate . " 23:59:59"))]);
            if (!empty($request->order_status)) {
                $orders->where('order_status', $orderStatus);
            }
            if ($searchTerm) {
                $orders->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->whereHas('customer', function ($query) use ($searchTerm) {
                        $query->where('nama', 'LIKE', '%' . $searchTerm . '%');
                    })->orWhereHas('branch', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })->orWhere('order_code', 'LIKE', '%' . $searchTerm . '%');
                });
            }
            $orders = $orders->get();
            $order_status = OrderStatus::getDescriptionArray();
            foreach ($orders as $key => $order) {
                $nama_customer = $order->customer->nama;
                $store = $order->address->address_name;
                $area = $order->address->city->name;
                $status = $order_status[$order->order_status][0];
                $split = 0;
                $stand = 0;
                $cassete = 0;
                $central = 0;
                $tanggal = date('d F Y', strtotime($order->booked_date));
                $jam = date('H:i', strtotime($order->booked_date));
                $jenis_servis = '';
                $teknisi = '';
                $biaya = '';
                $diskon = $order->diskon;
                $grand_total = $order->grand_total;
                foreach ($order->order_details as $key => $order_detail) {
                    $jenis = $order_detail->master_ac?->ac?->model;
                    if ($jenis == 'Split Wall') {
                        $split++;
                    } else if ($jenis == 'Central') {
                        $central++;
                    } else if ($jenis == 'Standing Floor') {
                        $stand++;
                    } else if ($jenis == 'Cassette') {
                        $cassete++;
                    }
                }
                foreach ($order->teams as $team) {
                    $i = 1;
                    foreach ($team->technician as $tech) {
                        $teknisi .= $tech->fullname;
                        if ($i != count($team->technician)) {
                            $teknisi .= ', ';
                        }
                        $i++;
                    }
                }
                $numb = 1;
                foreach ($order->serviceCounts as $count) {
                    $jenis_servis .= $count['count'] . " Unit " . $count['service_name'];
                    $biaya .= "Rp " . $count['price'];
                    if ($numb != count($order->serviceCounts)) {
                        $jenis_servis .= ', ';
                        $biaya .= ', ';
                    }
                    $numb++;
                }
                $collection[] = [
                    $nama_customer,
                    $store,
                    $area,
                    $status,
                    $split,
                    $stand,
                    $cassete,
                    $central,
                    $tanggal,
                    $jam,
                    $jenis_servis,
                    $teknisi,
                    $biaya,
                    $diskon,
                    $grand_total,
                ];
            }
            return Excel::download(new Document($collection, $heading), 'data-order' . '-' . date('d-m-Y', strtotime($startDate)) . '_' . date('d-m-Y', strtotime($endDate)) . '.' . 'xls');
        } elseif ($button_status == 'download') {
            $collection = [];

            $heading = [
                'Nama Customer',
                'Store',
                'Area',
                'status',
                'split',
                'stand',
                'cassete',
                'central',
                'tanggal',
                'jam',
                'jenis servis',
                'Teknisi',
                '@Rp Biaya Servis',
                'Diskon',
                'Total Biaya Rp',
            ];
            $dates = explode(" - ", $request->booked_date);
            $startDate = date('Y-m-d', strtotime($dates[0]));
            $endDate = date('Y-m-d', strtotime($dates[1]));
            $orders = Order::whereBetween('booked_date', [$startDate, date('Y-m-d H:i:s', strtotime($endDate . " 23:59:59"))]);
            if (!empty($request->order_status)) {
                $orders->where('order_status', $orderStatus);
            }

            if ($searchTerm) {
                $orders->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->whereHas('customer', function ($query) use ($searchTerm) {
                        $query->where('nama', 'LIKE', '%' . $searchTerm . '%');
                    })->orWhereHas('branch', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })->orWhere('order_code', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('ref_no', 'LIKE', '%' . $searchTerm . '%');
                });
            }
            $orders = $orders->get();
            $order_status = OrderStatus::getDescriptionArray();
            foreach ($orders as $key => $order) {
                foreach ($order->serviceCounts as $count) {
                    $nama_customer = $order->customer->nama;
                    $store = $order->address->address_name;
                    $area = $order->address->city->name;
                    $status = $order_status[$order->order_status][0];
                    $split = 0;
                    $stand = 0;
                    $cassete = 0;
                    $central = 0;
                    $tanggal = date('d F Y', strtotime($order->booked_date));
                    $jam = date('H:i', strtotime($order->booked_date));
                    $jenis_servis = '';
                    $teknisi = '';
                    $biaya = '';
                    $diskon = $count['discount'];
                    $grand_total = $count['total_service'];
                    $jenis_servis .= $count['count'] . " Unit " . $count['service_name'];
                    $biaya .= "Rp " . $count['price'];
                    foreach ($order->teams as $team) {
                        $i = 1;
                        foreach ($team->technician as $tech) {
                            $teknisi .= $tech->fullname;
                            if ($i != count($team->technician)) {
                                $teknisi .= ', ';
                            }
                            $i++;
                        }
                    }
                    $collection[] = [
                        $nama_customer,
                        $store,
                        $area,
                        $status,
                        $split,
                        $stand,
                        $cassete,
                        $central,
                        $tanggal,
                        $jam,
                        $jenis_servis,
                        $teknisi,
                        $biaya,
                        $diskon,
                        $grand_total,
                    ];
                }
            }
            return Excel::download(new Document($collection, $heading), 'data-order' . '-' . date('d-m-Y', strtotime($startDate)) . '_' . date('d-m-Y', strtotime($endDate)) . '.' . 'xls');
        }
    }
    public function warranty_orders(Request $request)
    {
        $searchTerm = $request->input('search');
        $orderStatus = $request->input('order_status');
        $bookedDate = $request->input('booked_date');

        // Query the orders based on the filter parameters
        $query = Order::with('customer', 'address', 'branch', 'order_details')->orderBy('booked_date', 'desc');

        if ($searchTerm) {
            $query->where(function ($innerQuery) use ($searchTerm) {
                $innerQuery->whereHas('customer', function ($query) use ($searchTerm) {
                    $query->where('nama', 'LIKE', '%' . $searchTerm . '%');
                })->orWhereHas('branch', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                })->orWhere('order_code', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        if ($orderStatus) {
            $query->where('order_status', $orderStatus);
        }

        if ($bookedDate) {
            $dates = explode(" - ", $bookedDate);

            $startDate = date('Y-m-d', strtotime($dates[0]));
            $endDate = date('Y-m-d', strtotime($dates[1]));
            $query->whereDate('booked_date', '>=', $startDate)
                ->whereDate('booked_date', '<=', $endDate);
        }
        $query->where('is_warranty', true);
        $orders = $query->get();
        $orders->each(function ($order) {
            $order->serviceCounts = $order->getServiceCountsAttribute();
        });
        $data = [
            'orders' => $orders,
            'statusorder' => OrderStatus::getDescriptionArray(),
            'array_status' => OrderStatus::getStatus(),
            'filter' => [
                'search' => $searchTerm,
                'order_status' => $orderStatus,
                'booked_date' => $bookedDate
            ],
        ];

        return view('orders.warranty', $data);
    }

    public function confirm_warranty_orders($id, Request $request)
    {
        $order = Order::find($id);
        $order->order_status = OrderStatus::TEKNISI_DITUGASKAN;
        if ($request->status == 'tolak') {
            $order->order_status = OrderStatus::PENGAJUAN_GARANSI_DITOLAK;
        }
        $order->save();
        return to_route('orders.show', $id)->with('toast_success', 'Garansi Berhasil di Konfirmasi');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data = [
            'branchs' => Branch::pluck('name', 'id'),
            'setting' => Setting::where('key', 'transportation')->first(),
            'group_service' => ServicesGroup::pluck('name', 'id'),
            'b2b2c' => MasterCustomer::where('type', 2)
        ];
        return view('orders.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
            // dd($request->all());
            // dd($request->input('sparepart'));
            $count = Order::withTrashed()->count();
            $orderCode = "TR-AMC-" . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
            $order = new Order;
            $order->ref_no = $request->input('ref_no');
            $order->booked_date = date('Y-m-d H:i', strtotime($request->input('booked_date')));
            $order->branch_id = $request->input('branch_id');
            $order->subscription_id = $request->input('subscription');
            $order->master_address_id = $request->input('master_address_id');
            $order->master_customer_id = $request->input('master_customer_id');
            $order->payment_status = OrderStatus::BELUM_BAYAR;
            $order->total_ac = resetNumberFormat($request->input('total_ac'));
            $order->total_base_price = resetNumberFormat($request->input('total_harga_service'));
            $order->reason = $request->input('reason');
            $order->keterangan = $request->input('keterangan');
            $order->location_range = resetNumberFormat($request->input('location_range'));
            $order->transport_fee = resetNumberFormat($request->input('transport_fee'));
            $order->sub_total = resetNumberFormat($request->input('total_harga_service')) + resetNumberFormat($request->input('transport_fee'));
            $order->diskon = resetNumberFormat($request->input('diskon'));
            $order->grand_total = resetNumberFormat($request->input('grand_total'));
            $order->service_group_id = $request->input('service_group');
            $order->order_status = 1;
            $order->customer_b2b2c_id = $request->input('customer_b2b2c_id');
            $order->created_by = Auth::guard('web')->user()->id;
            if (!empty($request->input('subscription'))) {
                $order->order_status = 2;
                $order->payment_type = OrderStatus::SUBSCRIPTION;
                $order->payment_status = OrderStatus::LUNAS;
            }
            $order->order_method = 'Manual by Admin';
            $order->order_code = $orderCode;
            $order->save();

            $services = [];
            $sum_service = 0;

            foreach ($request->input('services') as $service) {
                $sum_service += (int) $service['quantity'];
                for ($i = 1; $i <= (int) $service['quantity']; $i++) {
                    $discount = resetNumberFormat($service['discount']) / (int)$service['quantity'];
                    $subtotal = resetNumberFormat($service['harga']) - resetNumberFormat($discount);
                    $insert = [
                        'order_id' => $order->id,
                        'service_id' => $service['service_id'],
                        'order_detail_status' => 1,
                        'base_price' => resetNumberFormat($service['harga']),
                        'discount' => resetNumberFormat($discount),
                        'sub_total' => $subtotal,
                    ];
                    array_push($services, $insert);
                }
            }
            $spare_parts = [];
            foreach ($request->input('sparepart') as $spare_part) {
                $insert_spare_part=[
                    'order_id' => $order->id,
                    'spare_part_id' => $spare_part['spare_part_id'],
                    'quantity' => $spare_part['quantity'],
                    'base_price' => resetNumberFormat($spare_part['harga']),
                    'discount' => resetNumberFormat($spare_part['discount']),
                    'total_price' => resetNumberFormat($spare_part['subtotal']),
                ];
                array_push($spare_parts, $insert_spare_part);
            }
            if(!empty($spare_parts)){
                OrderSparePartDetail::insert($spare_parts);
            }
            OrderDetail::insert($services);
            if (!empty($request->input('subscription'))) {
                $subscription = Subscription::find($request->input('subscription'));
                $sisa_subs = (int)$subscription->amount_subscription - (int)$subscription->amount_worked;
                if ($sum_service <= $sisa_subs) {
                    $subscription->amount_worked = (int)$subscription->amount_worked + $sum_service;
                    if ($subscription->amount_worked == $subscription->amount_subscription) {
                        $subscription->end_date = date('Y-m-d');
                        $subscription->status = SubscriptionStatus::SELESAI;
                    }
                    $subscription->save();
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('toast_error', 'service melebihi batas subscription');
                }
            }

            //Pembayaran
            if (!empty($request->input('payment_type'))) {
                $imagePath = null;
                if ($request->file('bukti_pembayaran')) {
                    // Validate the form data
                    $imagePath = uploadFile('bukti_pembayaran', 'public/images/orders/payment', null, false, 'payment_receipt');
                }
                if ($request->input('payment_type') == OrderStatus::TERM_OF_PAYMENT) {
                    $order->payment_duedate = date('Y-m-d', strtotime($request->input('payment_duedate')));
                    $order->payment_status = OrderStatus::BELUM_BAYAR;
                    $order->payment_details = $request->input('payment_detail');
                    $order->payment_type = $request->input('payment_type');
                    $order->order_status = 2;
                } else {
                    $order->payment_date = date('Y-m-d H:i');
                    $order->payment_type = $request->input('payment_type');
                    $order->order_status = 2;
                    $order->payment_status = OrderStatus::LUNAS;
                    dd($imagePath);
                    $order->file_receipt = $imagePath;
                }
                $order->save();
            }

            //assign Team
            if (!empty($request->team_id)) {
                $status = '3'; // Replace with the desired status value

                $teams = [];
                foreach ($request->team_id as $teamId) {
                    $teams[$teamId] = ['status_team' => $status];
                }

                $order->teams()->syncWithoutDetaching($teams);
                $order->order_status = 3;
                if ($order->save()) {
                    $order->teams()->update(['status' => 1]);
                }
            }
            DB::commit();
            return to_route('orders.show', $order->id)->with('toast_success', 'Order Berhasil Ditambahkan');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'Order Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $qr = MasterQr::where('master_customer_id', $order->master_customer_id)
            ->orWhere('status', 0)
            ->get();
        $data = array(
            'order' => $order,
            'statusorder' => OrderStatus::getDescriptionArray(),
            'statuspayment' => OrderStatus::getPaymentDescriptionArray(),
            'qr' => $qr
        );
        // Check if the order was created by the admin itself
        // if ($order->created_by == auth()->user()->id || auth::user()->hasPermissionTo('*')) {
        return view('orders.show', $data);
        // } else {
        //     return redirect()->back()->with('toast_error', 'You are not authorized to view this order.');
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);

        $customer = MasterCustomer::find($order->master_customer_id);
        $service = [];
        if ($customer->type == 1) {
            $service = Service::orderBy('name', 'asc')
                ->where('is_active', 1)
                ->whereNull('paket_id')
                ->where('master_customer_id', $customer->id)
                ->get(['id', 'name', 'price']);
        } else {
            $service = Service::orderBy('name', 'asc')
                ->where('is_active', 1)
                ->whereNull('master_customer_id')
                ->whereNull('paket_id')
                ->get(['id', 'name', 'price']);
        }
        $data = [
            'branchs' => Branch::pluck('name', 'id'),
            'order' => $order,
            'subscription' => Subscription::where('id', $order->master_customer_id)->pluck('name', 'id'),
            'customer' => MasterCustomer::pluck('nama', 'id'),
            'address' => MasterAddress::where('master_customer_id', $order->master_customer_id)->orderBy('id', 'asc')->pluck('address_name', 'id'),
            'setting' => Setting::where('key', 'transportation')->first(),
            'group_service' => ServicesGroup::pluck('name', 'id'),
            'services' => $service,
            'b2b2c' => MasterCustomer::where('type', 2)
        ];
        return view('orders.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OrderRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $order = Order::find($id);
            $order->ref_no = $request->input('ref_no');
            $order->booked_date = date('Y-m-d H:i', strtotime($request->input('booked_date')));
            $order->branch_id = $request->input('branch_id');
            $order->subscription_id = $request->input('subscription');
            $order->master_address_id = $request->input('master_address_id');
            $order->master_customer_id = $request->input('master_customer_id');
            $order->payment_status = OrderStatus::BELUM_BAYAR;
            $order->total_ac = resetNumberFormat($request->input('total_ac'));
            $order->total_base_price = resetNumberFormat($request->input('total_harga_service'));
            $order->reason = $request->input('reason');
            $order->keterangan = $request->input('keterangan');
            $order->location_range = resetNumberFormat($request->input('location_range'));
            $order->transport_fee = resetNumberFormat($request->input('transport_fee'));
            $order->sub_total = resetNumberFormat($request->input('total_harga_service')) + resetNumberFormat($request->input('transport_fee'));
            $order->diskon = resetNumberFormat($request->input('diskon'));
            $order->grand_total = resetNumberFormat($request->input('grand_total'));
            $order->service_group_id = $request->input('service_group');
            $order->save();

            if ($request->input('services') && $request->change_services == 'true') {
                $services = [];
                $sum_service = 0;
                $order->order_details()->delete();
                foreach ($request->input('services') as $service) {
                    $sum_service += (int) $service['quantity'];
                    for ($i = 1; $i <= (int) $service['quantity']; $i++) {
                        $discount = resetNumberFormat($service['discount']) / (int)$service['quantity'];
                        $subtotal = resetNumberFormat($service['harga']) - resetNumberFormat($discount);
                        $insert = [
                            'order_id' => $order->id,
                            'service_id' => $service['service_id'],
                            'order_detail_status' => 1,
                            'base_price' => resetNumberFormat($service['harga']),
                            'discount' => resetNumberFormat($discount),
                            'sub_total' => $subtotal,
                        ];
                        array_push($services, $insert);
                    }
                }
                OrderDetail::insert($services);
            }
            DB::commit();
            return to_route('orders.index')->with('toast_success', 'Order Berhasil di ubah');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'Order Gagal Di ubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return to_route('orders.index')->with('toast_success', 'Order Berhasil di hapus');
    }

    public function payment($id, Request $request)
    {
        $validatedData = $request->validate([
            'payment_type' => 'required',
            'image' => 'file|mimes:jpeg,png|max:2048',
        ]);
        $imagePath = null;
        if ($request->file('bukti_pembayaran')) {
            // Validate the form data
            $imagePath = uploadFile('bukti_pembayaran', 'public/images/orders/payment', null, false, 'payment_receipt');
        }
        $order = Order::findOrFail($id);
        if ($request->input('payment_type') == OrderStatus::TERM_OF_PAYMENT) {
            $order->payment_duedate = date('Y-m-d', strtotime($request->input('payment_duedate')));
            $order->payment_status = OrderStatus::BELUM_BAYAR;
            $order->payment_details = $request->input('payment_detail');
            $order->payment_type = $request->input('payment_type');
            $order->order_status = 2;
        } else {
            $order->payment_date = date('Y-m-d H:i');
            $order->payment_type = $request->input('payment_type');
            $order->order_status = 2;
            $order->payment_status = OrderStatus::LUNAS;
            $order->file_receipt = $imagePath;
        }
        $order->save();

        return to_route('orders.show', $id)->with('toast_success', 'Payment Order Berhasil Di Upload');
    }

    public function assignteam($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $status = '3'; // Replace with the desired status value

            $teams = [];
            foreach ($request->team_id as $teamId) {
                $teams[$teamId] = ['status_team' => $status];
            }

            $order->teams()->syncWithoutDetaching($teams);
            $order->order_status = 3;
            if ($order->save() && date('Y-m-d', strtotime($order->booked_date)) == date('Y-m-d')) {
                $order->teams()->update(['status' => 1]);
            }
            DB::commit();
            return to_route('orders.show', $id)->with('toast_success', 'Team Berhasil ditugaskan');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'Team Gagal Ditugaskan');
        }
    }

    public function deleteassignteam($id, Request $request)
    {
        $order = Order::findOrFail($id);
        $order->teams()->detach($request->team_id);
        if ($order->teams->isEmpty()) {
            $order->order_status = 2;
            $order->save();
        }
        return to_route('orders.show', $id)->with('toast_success', 'Team Berhasil dihapus');
    }

    public function completedorder($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $qr = MasterQr::where('url_unique', $request->qr_id)->first();

            $team = Team::find($request->team_id);
            $acCustomer = null;
            if (!empty($qr) && $request->qr_status == 0) {
                $insert = MasterAc::insertGetId([
                    'brand' => $request->brandAC,
                    'ac_name' => $request->nama_ac,
                    'model' => $request->model_ac,
                    'pk' => $request->pk,
                    'is_inverter' => $request->is_inverter,
                    'freon_type' => $request->tipe_freon,
                ]);
                $ac = $insert;
                $acCustomer = AcCustomer::insertGetId([
                    'master_ac_id' => $ac,
                    'master_qr_id' => $qr->id,
                    'master_customer_id' => $order->master_customer_id,
                    'master_address_id' => $order->master_address_id,
                    'room_name' => $request->room_name,
                ]);
                $qr->update([
                    'status' => 1,
                    'master_teknisi_id' => null,
                    'master_ac_customer_id' => $acCustomer,
                    'master_customer_id' => $order->master_customer_id,
                ]);
            } else if (!empty($qr)) {
                $acCustomer = $qr->master_ac_customer_id;
            }
            $update = [
                'order_detail_status' => 2,
                'team_id' => $team?->id,
                'ac_customer_id' => $acCustomer,
            ];
            OrderDetail::whereIn('id', $request->service)->where('order_detail_status', 1)->update($update);
            $data = OrderDetail::where(['order_id' => $id, 'order_detail_status' => 1])->count();
            $order_detail = OrderDetail::whereIn('id', $request->service)->get();
            $count_team = Team::whereIn('id', $order->teams()->pluck('teams.id'))->count();
            $commissions = [];
            $order = Order::find($id);
            if ($order->is_warranty == 0) {

                foreach ($team->technician as $technician) {
                    foreach ($order_detail as $details) {
                        // Catatan Status Komisi
                        // 1 tambah komisi
                        // 2 kurang komisi
                        // 3 perbaikan
                        $commissions[] = [
                            'order_detail_id' => $details->id,
                            'technician_id' => $technician->id,
                            'nama_komisi' => $details->service->name,
                            'keterangan_komisi' => "Komisi " . $details->service->name . "untuk customer " . $details->order->customer->nama . " Lokasi di " . $details->order->address->completedAddress,
                            'nominal_komisi' => $details->service->commision / $count_team,
                            'status_komisi' => 1,
                            'created_at' => now(),
                        ];
                        OrderDetail::where('id', $details->id)->update([
                            'warranty' => Carbon::now()->addDays($details->service->warranty),
                        ]);
                    }
                }
                TechnicianCommission::insert($commissions);
            }
            $data = OrderDetail::where(['order_id' => $id, 'order_detail_status' => 1])->count();
            if ($data <= 0) {
                Order::where('id', $id)->update([
                    'order_status' => 6,
                ]);
                $order = Order::find($id);
                $order->teams()->update(['status' => 0]);

                $order->teams()->syncWithoutDetaching(
                    $order->teams->mapWithKeys(function ($team) {
                        return [$team->id => ['status_team' => 6]];
                    })
                );
            }

            $acCustomer = AcCustomer::find($acCustomer);
            // $next_service= Carbon::now()->addMonths(2);
            // if($acCustomer->next_service != null || $acCustomer->next_service != 0){
            //     $next_service = Carbon::now()->addDays($request->next_service);
            // }
            if (!empty($acCustomer)) {
                $acCustomer->update([
                    'last_service' => now(),
                    // 'next_service' => $next_service,
                ]);
            }
            DB::commit();
            return to_route('orders.show', $id)->with('toast_success', 'success menambahkan completed order');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'failed menambahkan completed order');
        }
    }



    public function completedpayment(Order $orders, Request $request)
    {
        $imagePath = null;
        if ($request->file('bukti_pembayaran')) {
            // Validate the form data
            $imagePath = uploadFile('bukti_pembayaran', 'public/images/orders/payment', null, false, 'payment_receipt');
        }
        $orders->payment_date = date('Y-m-d H:i', strtotime($request->payment_date));
        $orders->payment_status = OrderStatus::LUNAS;
        $orders->file_receipt = $imagePath;
        $orders->save();
        return to_route('orders.show', $orders->id)->with('toast_success', 'Pembayaran Berhasil');
    }
    public function revision($id)
    {
        $order = Order::findOrFail($id);
        $customer = MasterCustomer::find($order->master_customer_id);
        $service = [];
        if ($customer->type == 1) {
            $service = Service::orderBy('name', 'asc')
                ->where('is_active', 1)
                ->whereNull('paket_id')
                ->where('master_customer_id', $customer->id)
                ->get(['id', 'name', 'price']);
        } else {
            $service = Service::orderBy('name', 'asc')
                ->where('is_active', 1)
                ->whereNull('master_customer_id')
                ->whereNull('paket_id')
                ->get(['id', 'name', 'price']);
        }
        $data = [
            'branchs' => Branch::pluck('name', 'id'),
            'order' => $order,
            'subscription' => Subscription::where('id', $order->master_customer_id)->pluck('name', 'id'),
            'customer' => MasterCustomer::pluck('nama', 'id'),
            'address' => MasterAddress::where('master_customer_id', $order->master_customer_id)->orderBy('id', 'asc')->pluck('address_name', 'id'),
            'services' => $service,
            'setting' => Setting::where('key', 'transportation')->first(),
            'group_service' => ServicesGroup::pluck('name', 'id'),
            'b2b2c' => MasterCustomer::where('type', 2)
        ];
        return view('orders.revision', $data);
    }
    public function revisionupdate(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $history = $order->replicate([
                'id',
                'reason_canceled',
            ]);
            $history->revision_date = date('Y-m-d');
            $history->order_id = $id;
            $history = $history->toArray();
            $data_history = OrderHistory::create($history);
            $order = Order::findOrFail($id);
            $order->ref_no = $request->input('ref_no');
            $order->payment_status = OrderStatus::BELUM_LUNAS;
            $order->payment_date = NULL;
            $order->booked_date = date('Y-m-d H:i', strtotime($request->input('booked_date')));
            $order->branch_id = $request->input('branch_id');
            $order->subscription_id = $request->input('subscription');
            $order->master_address_id = $request->input('master_address_id');
            $order->master_customer_id = $request->input('master_customer_id');
            $order->total_ac = resetNumberFormat($request->input('total_ac'));
            $order->total_base_price = resetNumberFormat($request->input('total_harga_service'));
            $order->reason = $request->input('reason');
            $order->keterangan = $request->input('keterangan');
            $order->location_range = resetNumberFormat($request->input('location_range'));
            $order->transport_fee = resetNumberFormat($request->input('transport_fee'));
            $order->sub_total = resetNumberFormat($request->input('total_harga_service')) + resetNumberFormat($request->input('transport_fee'));
            $order->diskon = resetNumberFormat($request->input('diskon'));
            $order->grand_total = resetNumberFormat($request->input('grand_total'));
            $order->service_group_id = $request->input('service_group');
            $order->save();
            if ($request->input('services')) {
                $services = [];
                $sum_service = 0;
                $order->order_details();
                foreach ($order->order_details as $detail) {
                    $detail_history = $detail->replicate([
                        'id',
                        'order_id',
                    ]);
                    $detail_history->order_history_id = $data_history->id;
                    $detail_history = $detail_history->toArray();
                    $data_history_detail = OrderDetailHistory::create($detail_history);
                    $detail->delete();
                }
                foreach ($request->input('services') as $service) {
                    $sum_service += (int) $service['quantity'];
                    for ($i = 1; $i <= (int) $service['quantity']; $i++) {
                        $discount = resetNumberFormat($service['discount']) / (int)$service['quantity'];
                        $subtotal = resetNumberFormat($service['harga']) - resetNumberFormat($discount);
                        $insert = [
                            'order_id' => $order->id,
                            'service_id' => $service['service_id'],
                            'order_detail_status' => 1,
                            'base_price' => resetNumberFormat($service['harga']),
                            'discount' => resetNumberFormat($discount),
                            'sub_total' => $subtotal,
                        ];
                        array_push($services, $insert);
                    }
                }
                OrderDetail::insert($services);
            }
            DB::commit();
            return to_route('orders.show', $id)->with('toast_success', 'Revisi Order Berhasil');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'Revisi Order Gagal');
        }
    }
    public function canceled_order(Order $orders, Request $request)
    {
        $orders->order_status = OrderStatus::DIBATALKAN;
        $orders->reason_canceled = $request->input('reason');
        $orders->save();
        return to_route('orders.index')->with('toast_success', 'Order Berhasil di Batalkan');
    }

    public function upload_work_order(Order $orders, Request $request)
    {
        $imagePath = null;
        if ($request->file('work_order')) {
            // Validate the form data
            $imagePath = uploadFile('work_order', 'public/images/orders/work_order', null, false, 'work_order');
        }
        $orders->work_order = $imagePath;
        $orders->save();
        return to_route('orders.show', $orders->id)->with('toast_success', 'Work Order Berhasil Di Upload');
    }
    public function invoice(Order $orders)
    {
        $data = [
            'orders' => [$orders],
        ];

        if ($orders->customer_b2b2c == null) { // Use null instead of nil
            $pdf = Pdf::loadView('orders.invoice', $data)->setPaper('a4', 'landscape');
            $title = $orders->type == 1 ? $orders->customer->company_name : $orders->customer->nama;
        } else {
            $pdf = Pdf::loadView('orders.invoice_gree', $data)->setPaper('a4', 'portrait');
            $title = $orders->ref_no;

            $tempPath = storage_path('app/temp/');
            if (!File::exists($tempPath)) {
                File::makeDirectory($tempPath, 0755, true);
            }

            // Save the generated PDF to a temporary file
            $pdfPath = $tempPath . $title . '-invoice.pdf';
            $pdf->save($pdfPath);
        }

        return $pdf->stream($title . '-invoice.pdf');
    }
    public function upload_work_order_doc(Order $orders, Request $request)
    {
        $imagePath = null;
        $invoice_path = 'app/public/invoices/';


        if ($request->file('work_order_doc')) {
            // Validate the form data
            $imagePath = uploadFile('work_order_doc', 'public/images/orders/work_order_doc', null, false, 'work_order_doc');
        }
        $orders->work_order_doc = $imagePath;
        $orders->save();
        $data = [
            'orders' => [$orders],
        ];

        if(!File::exists("app/temp/{$orders->ref_no}-invoice.pdf")){
            $pdf = Pdf::loadView('orders.invoice_gree', $data)->setPaper('a4', 'portrait');
            $title = $orders->ref_no;

            $tempPath = storage_path('app/temp/');
            if (!File::exists($tempPath)) {
                File::makeDirectory($tempPath, 0755, true);
            }

            // Save the generated PDF to a temporary file
            $pdfPath = $tempPath . $title . '-invoice.pdf';
            $pdf->save($pdfPath);
        }
        // Initialize PDFMerger
        $oMerger = PDFMerger::init();

        // Add the first PDF (e.g., an invoice) from the storage path
        $oMerger->addPDF(storage_path("app/temp/{$orders->ref_no}-invoice.pdf"), 'all');

        // Add the uploaded work order document
        $oMerger->addPDF(storage_path('app/public/images/orders/work_order_doc/' . $orders->work_order_doc), 'all');

        // Merge the PDFs and save the result
        $oMerger->merge();
        $tempPath = storage_path($invoice_path);

        if (!File::exists($tempPath)) {
            File::makeDirectory($tempPath, 0755, true);
        }

        $mergedFileName = "{$orders->ref_no}_{$orders->customer_b2b2c->nama}.pdf";
        $mergedFilePath = $invoice_path . $mergedFileName;
        $oMerger->save(storage_path($mergedFilePath));

        $orders->complete_invoice = $mergedFileName;
        $orders->save();
        if(File::exists("app/temp/{$orders->ref_no}-invoice.pdf")){
            removeFile("{$orders->ref_no}-invoice.pdf","app/temp/");
        }
        return to_route('orders.show', $orders->id)->with('toast_success', 'Work Order Berhasil Di Upload');
    }


    public function report_order(Request $request)
    {
        $button_status = $request->input('button_status');
        $bookedDate = $request->input('booked_date');
        [$startDate, $endDate] = $bookedDate
            ? array_map(fn ($date) => date('Y-m-d', strtotime($date)), explode(" - ", $bookedDate))
            : [date('Y-m-d'), date('Y-m-d')];
        // dd($bookedDate, $startDate, $endDate);
        if (!$bookedDate) {
            $bookedDate = date('m/d/Y') . ' - ' . date('m/d/Y');
        }
        $orders = Order::when($bookedDate, function ($query, $bookedDate) use ($startDate, $endDate) {
            return $query->whereBetween('booked_date', [$startDate, date('Y-m-d H:i:s', strtotime($endDate . " 23:59:59"))]);
        })
            ->where('order_status', '!=', OrderStatus::DIBATALKAN)
            ->orderBy('booked_date', 'ASC')
            ->get();
        $order_status = OrderStatus::getDescriptionArray();
        if ($button_status == 'search' || empty($button_status)) {
            // dd($orders->count());
            return view('orders.report_order', [
                'orders' => $orders,
                'statusorder' => $order_status,
                'filter' => ['booked_date' => $bookedDate ?? ''],
            ]);
        } elseif ($button_status == 'download') {
            $collection = [];

            $heading = [
                'Order Code',
                'Nama Customer',
                'Nama Alamat',
                'Order Status',
                'Sub Total',
                'Diskon',
                'Grand Total',
            ];

            if (!$orders->isEmpty()) {
                $tanggal = !$orders->isEmpty()
                    ? formatDate($orders[0]->booked_date, 'Y-m-d')
                    : null;
                $no = 1;
                $sub_total_tanggal = 0;
                $diskon_tanggal = 0;
                $grand_total_tanggal = 0;
                $sub_total = 0;
                $diskon = 0;
                $grand_total = 0;
                $total_data = $orders->count();

                foreach ($orders as $order) {
                    if ($no == 1 || formatDate($order->booked_date, 'Y-m-d') != $tanggal) {
                        $tanggal = formatDate($order->booked_date, 'Y-m-d');
                        if ($no > 1) {
                            $collection[] = [
                                'Sub Total',
                                '',
                                '',
                                '',
                                thousand_rupiah($sub_total_tanggal),
                                thousand_rupiah($diskon_tanggal),
                                thousand_rupiah($grand_total_tanggal),
                            ];
                            $sub_total_tanggal = 0;
                            $diskon_tanggal = 0;
                            $grand_total_tanggal = 0;
                        }
                        $collection[] = [
                            '',
                            '',
                            '',
                            formatDate($order->booked_date, 'd F Y'),
                            '',
                            '',
                            '',
                        ];
                    }
                    $collection[] = [
                        $order->order_code,
                        $order->customer?->nama,
                        $order->address?->address_name,
                        $order_status[$order->order_status][0],
                        thousand_rupiah($order->sub_total),
                        thousand_rupiah($order->diskon),
                        thousand_rupiah($order->grand_total),
                    ];
                    $sub_total += $order->total_base_price;
                    $diskon += $order->diskon;
                    $grand_total += $order->grand_total;
                    $sub_total_tanggal += $order->total_base_price;
                    $diskon_tanggal += $order->diskon;
                    $grand_total_tanggal += $order->grand_total;
                    if ($no == $total_data) {
                        $collection[] = [
                            'Sub Total',
                            '',
                            '',
                            '',
                            thousand_rupiah($sub_total_tanggal),
                            thousand_rupiah($diskon_tanggal),
                            thousand_rupiah($grand_total_tanggal),
                        ];
                    }
                    $no++;
                }
                $collection[] = [
                    'Grand Total',
                    '',
                    '',
                    '',
                    thousand_rupiah($sub_total),
                    thousand_rupiah($diskon),
                    thousand_rupiah($grand_total),
                ];
            }
            return Excel::download(new Document($collection, $heading), 'data-day-to-day-order' . '-' . date('d-m-Y', strtotime($startDate)) . '_' . date('d-m-Y', strtotime($endDate)) . '.' . 'xls');
        }
    }

    public function spk_pdf($id)
    {
        $orders = OrderDetail::where('id', $id)->first();
        $attachment = OrderDetailAttachment::where('order_detail_id', $id)->groupBy('attachment_id')->select('attachment_id')->get();
        $data = [
            'orders' => $orders,
            'attachment' => $attachment
        ];
        $pdf = Pdf::loadView('orders.spk', $data)->setPaper('a4', 'potrait');
        $title = $orders->type == 1 ? $orders->order->customer->company_name : $orders->order->customer->nama;
        return $pdf->stream($title . '-spk.pdf');
    }
}
