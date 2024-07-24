<?php

namespace App\Http\Controllers\Master;

use App\Enums\CustomerType;
use App\Http\Controllers\Controller;
use App\Enums\OrderStatus;
use App\Exports\Document;
use App\Http\Requests\MasterCustomerRequest;
use App\Models\MasterCustomer;
use App\Models\Order;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class MasterCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:mastercustomer-list|mastercustomer-create|mastercustomer-edit|mastercustomer-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:mastercustomer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:mastercustomer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:mastercustomer-delete', ['only' => ['destroy']]);
        $this->middleware('permission:mastercustomer-pin', ['only' => ['view_pin', 'update_pin']]);
        $this->middleware('permission:mastercustomer-invoice_customer', ['only' => ['invoice_customer']]);
    }
    public function index()
    {

        $data = array(
            'customers' => MasterCustomer::all(),
        );
        return view('customers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array(
            'customer' => new MasterCustomer,
            'customer_type' => CustomerType::getDescriptionArray(),
        );
        return view('customers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterCustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $insert = array(
                'type' => $request->type,
                'company_name' => $request->company_name,
                'nama' => $request->nama,
                'email' => $request->email,
                'phone' => $request->phone,
            );
            $customer = MasterCustomer::create($insert);
            if ($request->type == 1 || $request->type == 2) {
                $serviceData = Service::where('master_customer_id', null)->get();
                $serviceData = $serviceData->map(function ($item) use ($customer) {
                    unset($item['created_at']);
                    unset($item['updated_at']);
                    unset($item['is_show_mobile']);
                    unset($item['id']);
                    $item['master_customer_id'] = $customer->id; // replace $newMasterCustomerId with the actual value
                    return $item;
                });
                $createService = Service::insert($serviceData->toArray());
            }
            DB::commit();
            return view('customers.show', $customer);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->route('customers.index')->with('toast_error', 'Data Gagal Disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, MasterCustomer $masterCustomer)
    {
        $searchTerm = $request->input('search');
        $orderStatus = $request->input('order_status');
        $bookedDate = $request->input('booked_date');

        $query = Order::with('customer', 'address', 'branch', 'order_details')
            ->orderBy('booked_date', 'desc')
            ->where('master_customer_id', $masterCustomer->id);

        if ($searchTerm) {
            $query->where(function ($innerQuery) use ($searchTerm) {
                $innerQuery->whereHas('customer', function ($query) use ($searchTerm) {
                    $query->where('nama', 'LIKE', '%' . $searchTerm . '%');
                })
                    ->orWhereHas('branch', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })
                    ->orWhere('order_code', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if ($orderStatus) {
            $query->where('order_status', $orderStatus);
        }

        if ($bookedDate) {
            [$startDate, $endDate] = explode(" - ", $bookedDate);

            $query->whereBetween('booked_date', [
                date('Y-m-d', strtotime($startDate)),
                date('Y-m-d', strtotime($endDate))
            ]);
        }

        $scheduledOrder = Order::selectRaw('DATE(booked_date) AS date, COUNT(*) AS order_count')
            ->whereIn('order_status', [3, 4, 5])
            ->where('master_customer_id', $masterCustomer->id)
            ->whereNull('deleted_at')
            ->groupByRaw('date')
            ->orderBy('date', 'asc');

        $suggestService = $masterCustomer->masterAddress()
            ->whereHas('ac_customer', function ($query) {
                $startOfMonth = now()->startOfMonth()->format('Y-m-d');
                $endOfMonth = now()->endOfMonth()->format('Y-m-d');
                $query->whereBetween('next_service', [$startOfMonth, $endOfMonth]);
            })
            ->withCount(['ac_customer' => function ($query) {
                $startOfMonth = now()->startOfMonth()->format('Y-m-d');
                $endOfMonth = now()->endOfMonth()->format('Y-m-d');
                $query->whereBetween('next_service', [$startOfMonth, $endOfMonth]);
            }])
            ->get();

        $data = [
            'customer' => $masterCustomer,
            'statusorder' => OrderStatus::getDescriptionArray(),
            'array_status' => OrderStatus::getStatus(),
            'orders' => $query->get(),
            'scheduled_order' => $scheduledOrder->get(),
            'filter' => [
                'search' => $searchTerm,
                'order_status' => $orderStatus,
                'booked_date' => $bookedDate
            ],
            'suggest_service' => $suggestService
        ];
        // dd($masterCustomer->children);
        return view('customers.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterCustomer $masterCustomer)
    {
        $data = array(
            'customer' => $masterCustomer,
            'customer_type' => CustomerType::getDescriptionArray(),
        );

        return view('customers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterCustomerRequest $request, MasterCustomer $masterCustomer)
    {
        $update = array(
            'type' => $request->type,
            'company_name' => $request->company_name,
            'nama' => $request->nama,
            'email' => $request->email,
            'phone' => $request->phone,
        );
        $masterCustomer->update($update);
        return redirect()->route('customers.index')->with('toast_success', 'Data Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterCustomer $masterCustomer)
    {
        $masterCustomer->delete();
        return redirect()->route('customers.index')->with('toast_success', 'Data Berhasil Dihapus');
    }

    public function invoice_customer(MasterCustomer $masterCustomer, Request $request)
    {
        $data = [
            'orders' => $masterCustomer->orders()->whereIn('orders.id', $request->id)->get(),
        ];
        $pdf = Pdf::loadView('orders.invoice', $data)->setPaper('a4', 'landscape');
        $title = $masterCustomer->type == 1 ? $masterCustomer->company_name : $masterCustomer->nama;
        return $pdf->download($title . '-invoice.pdf');
    }

    public function view_pin(MasterCustomer $masterCustomer)
    {
        $data = array(
            'customer' => $masterCustomer
        );
        return view('customers.pin', $data);
    }
    public function update_pin(MasterCustomer $masterCustomer, Request $request)
    {
        $request->validate([
            'pin' => 'required|numeric|digits:6',
            'pin_confirmed' => 'required|numeric|digits:6|same:pin',
        ]);
        $update = [
            'pin' => Hash::make($request->pin),
            'is_verify' => 1,
        ];
        $masterCustomer->update($update);
        return redirect()->route('customers.index')->with('toast_success', 'PIN Berhasil Diedit');
    }

    public function export_invoice(MasterCustomer $masterCustomer, Request $request)
    {
        $collection = [];

        $heading = [
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
        $dates = explode(" - ", $request->date);
        $startDate = date('Y-m-d', strtotime($dates[0]));
        $endDate = date('Y-m-d', strtotime($dates[1]));
        $orders = Order::where('master_customer_id', $masterCustomer->id)->whereBetween('booked_date', [$startDate, $endDate])->get();
        $order_status = OrderStatus::getDescriptionArray();
        foreach ($orders as $key => $order) {
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
        return Excel::download(new Document($collection, $heading), $masterCustomer->company_name . '-' . date('d-m-Y', strtotime($startDate)) . '_' . date('d-m-Y', strtotime($endDate)) . '.' . 'xls');
    }
}
