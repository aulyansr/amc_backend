<?php

namespace App\Http\Controllers\Teknisi;

use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\RepairAttachmentItemController;
use App\Models\AcCustomer;
use App\Models\DetailPendingOrder;
use App\Models\MasterAc;
use App\Models\MasterQr;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailAttachment;
use App\Models\Team;
use App\Models\Technician;
use App\Models\Service;
use App\Models\TechnicianCommission;
use App\Models\RepairAttachmentDocument;
use App\Models\RepairAttachmentDocumentDetail;
use App\Models\RepairAttachment;
use App\Models\RepairAttachmentItem;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TechnicianPageController extends Controller
{
    public function index(Request $request)
    {
        $currentTechnician = auth()->guard('technician')->user();
        $firstTeam = $currentTechnician->teams->first();
        // Get the current date and end of the month
        $today = Carbon::tomorrow();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Get orders for today
        $orders_tomorrow = $firstTeam->orders()
            ->whereRaw("DATE(booked_date) BETWEEN ? AND ?", [$today, $endOfMonth])
            ->where('order_status', '!=', 6)
            ->get();

        // Get orders for tomorrow
        $tomorrow = Carbon::today();
        $orders_today = $firstTeam->orders()
            ->whereDate('booked_date', $tomorrow)
            ->where('order_status', '!=', 6)
            ->get();

        $orders = [
            'today' => $orders_today,
            'tomorrow' => $orders_tomorrow,
        ];
        $statusorder = OrderStatus::getDescriptionArray();
        $totalCommission = Technician::where('id', $currentTechnician->id)
            ->first()->technician_commission()
            ->whereDate('created_at', '>=', now()->startOfMonth())
            ->whereDate('created_at', '<=', now()->endOfMonth())
            ->sum('nominal_komisi');
        return view('page_teknisi.home', compact('orders', 'statusorder', 'totalCommission'));
    }


    public function orders()
    {
        $currentTechnician = auth()->guard('technician')->user();
        $firstTeam = $currentTechnician->teams->first();

        // Get the current date and end of the month
        $tomorrow = Carbon::tomorrow();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Get orders for tomorrow
        $orders_tomorrow = $firstTeam->orders()
            ->whereRaw("DATE(booked_date) BETWEEN ? AND ?", [$tomorrow, $endOfMonth])
            ->where('order_status', '!=', 6)
            ->get();

        // Get orders for tomorrow
        $today = Carbon::today();
        $orders_yesterday_not_complete = $firstTeam->orders()
            ->whereDate('booked_date', '<', $today)
            ->where('order_status', '!=', 6)
            ->where('order_status', '!=', 0)
            ->where('order_status', '!=', 9)
            ->get();
        $orders_today = $firstTeam->orders()
            ->whereDate('booked_date', $today)
            ->where('order_status', '!=', 6)
            ->where('order_status', '!=', 9)
            ->get();

        $orders_canceled = $firstTeam->orders()
            ->where('order_status', 0)
            ->get();

        $orders_finish = $firstTeam->orders()
            ->where('order_status', 6)
            ->get();

        $orders_pending = $firstTeam->orders()
            ->where('order_status', 9)
            ->get();

        $orders = [
            'today' => $orders_today,
            'tomorrow' => $orders_tomorrow,
            'canceled' => $orders_canceled,
            'finish' => $orders_finish,
            'not_completed' => $orders_yesterday_not_complete,
            'pending' => $orders_pending,
        ];
        return view('page_teknisi.orders', compact('orders'));
    }
    public function qr()
    {
        return view('page_teknisi.qr');
    }
    public function profile()
    {
        return view('page_teknisi.profile');
    }

    public function orderDetail($id)
    {
        $currentTechnician = auth()->guard('technician')->user();
        $firstTeam = $currentTechnician->teams->first();
        $order = $order = Order::whereHas('teams', function ($query) use ($firstTeam) {
            $query->where('teams.id', $firstTeam->id);
        })->findOrFail($id);
        $pivot = $order->teams->find($firstTeam->id)->pivot;
        $ac_customer = MasterQr::whereHas('ac_customer', function ($query) use ($order) {
            $query->where('master_customer_id', $order->master_customer_id);
            $query->where('master_address_id', $order->master_address_id);
        })
            ->get();
        // dd($ac_customer);
        $data = [
            'order' => $order,
            'firstTeam' => $firstTeam,
            'pivot' => $pivot,
            'statusorder' => OrderStatus::getDescriptionArray(),
            'ac_customer' => $ac_customer
        ];

        if ($order->order_status == 4) {
            return view('page_teknisi.update_order.check_in', $data);
        }
        return view('page_teknisi.order_detail', $data);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        // Validate the request and update the order status
        // Find the order by its ID
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $currentTechnician = auth()->guard('technician')->user();
        $firstTeam = $currentTechnician->teams->first();
        $newStatus = $request->input('new_status');
        $team = $order->teams->find($firstTeam->id);
        $team->pivot->status_team = $newStatus;
        $team->pivot->save();
        if ($order->teams->groupBy('pivot.status_team')->count() == 1) {


            // You can add validation here to ensure newStatus is a valid status code

            $order->order_status = (int)$order->order_status + 1;
            $order->save();
        }

        // Check if the order exists

        // Update the order status based on the request data

        // Return a response indicating success or failure
        return response()->json(['message' => 'Order status updated', 'order' => $order], 200);
    }

    public function detail_ac()
    {
        return view('page_teknisi.detail_ac');
    }
    public function status_order($id)
    {
        $order = Order::findOrFail($id);
        if ((int) $order->order_status > 2 && (int) $order->order_status < 5) {
            $order->order_status = (int) $order->order_status + 1;
            $order->save();
            return to_route('technician.home')->with('toast_success', 'Order Status Berhasil Di Update');
        } else {
            return to_route('technician.home')->with('toast_error', 'Order Status Gagal Di Update');
        }
    }

    public function qr_edit(MasterQr $qr)
    {
        $data = [
            'qr' => $qr,
            'ac' => MasterAc::all(),
        ];
        if ($qr->status == 1) {
            $currentTechnician = auth()->guard('technician')->user();
            $firstTeam = $currentTechnician->teams->first();
            $orders = Order::where([
                // 'order_status' => OrderStatus::DALAM_PENGERJAAN_TEKNISI,
                'master_customer_id' => $qr->ac_customer->master_customer_id,
                'master_address_id' => $qr->ac_customer->master_address_id,
            ])
                ->whereHas('teams', function ($query) use ($firstTeam) {
                    $query->where('teams.id', $firstTeam->id);
                })
                ->get()
                ->sortByDesc('created_at');
            $data = [
                'qr' => $qr,
                'ac' => $qr->ac_customer,
                'orders' => $orders,
            ];
            return view('page_teknisi.qr.add_service_qr', $data);
        }
        return redirect()->route('technician.add_detail_ac', $qr->url_unique);
    }

    public function add_detail_ac(Order $order)
    {
        $data['qr_list'] = MasterQr::where('status', 0)->get();
        $data['ac'] = MasterAc::all()->unique('ac_name');
        $data['order'] = $order;
        return view('page_teknisi.update_order.add_ac_detail', $data);
    }

    public function store_detail_ac(Order $order, Request $request)
    {
        try {
            DB::beginTransaction();
            $ac = '';
            if ($request->ac_option == 'pilih_ac') {
                $ac = $request->ac;
            } elseif ($request->ac_option == 'ac_baru') {
                $insert = MasterAc::insertGetId([
                    'brand' => $request->brandAC,
                    'ac_name' => $request->nama_ac,
                    'model' => $request->model_ac,
                    'pk' => $request->pk,
                    'is_inverter' => $request->is_inverter,
                    'freon_type' => $request->tipe_freon,
                ]);
                $ac = $insert;
            }
            $acCustomer = AcCustomer::create([
                'master_ac_id' => $ac,
                'master_qr_id' => $request->qr_id,
                'master_customer_id' => $order->master_customer_id,
                'master_address_id' => $order->master_address_id,
                'room_name' => $request->room_name,
            ]);
            MasterQr::where('id', $request->qr_id)->update([
                'status' => 1,
                'master_teknisi_id' => Auth::guard('technician')->user()->id,
                'master_ac_customer_id' => $acCustomer->id,
                'master_customer_id' => $request->master_customer_id,
            ]);
            // $order->status=OrderStatus::SERVICE_DIKERJAKAN;
            // $order->save;
            DB::commit();
            return redirect()->route('technician.orderDetail', $order->id)->with('toast_success', 'Detail AC Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'Detail AC Gagal Ditambahkan');
        }
    }
    // update customer hanyya di pilih waktu order dan waktu daftarin ac customer hanya simpan qr dan ac dulu
    public function store_service(MasterQr $qr, Request $request)
    {
        try {

            DB::beginTransaction();
            $team = auth()->guard('technician')->user()->teams->first()->id;
            $update = [
                'order_detail_status' => 2,
                'team_id' => $team,
                'ac_customer_id' => $request->ac_customer,
                'date_complete' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            OrderDetail::whereIn('id', $request->service)->where('order_detail_status', 1)->update($update);
            $data = OrderDetail::where(['order_id' => $request->order, 'order_detail_status' => 1])->count();
            $order_detail = OrderDetail::whereIn('id', $request->service)->get();
            $count_team = Team::where('id', $team)->count();
            $data_team = Team::where('id', $team)->first();
            $commissions = [];
            $order = Order::find($request->order);
            if ($order->is_warranty == 0) {
                foreach ($data_team->technician as $technician) {
                    foreach ($order_detail as $details) {
                        // Catatan Status Komisi
                        // 1 tambah komisi
                        // 2 kurang komisi
                        // 3 perbaikan
                        $commissions[] = [
                            'order_detail_id' => $details->id,
                            'technician_id' => $technician->id,
                            'nama_komisi' => $details->service->name,
                            'keterangan_komisi' => "Komisi " . $details->service->name . "untuk customer " . $details->master_ac->customer->nama . " Lokasi di " . $details->master_ac->address->completedAddress,
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
            if ($data <= 0) {
                Order::where('id', $request->order)->update([
                    'order_status' => 6,
                ]);
                $order = Order::find($request->order);
                $order->teams()->update(['status' => 0]);

                $order->teams()->syncWithoutDetaching(
                    $order->teams->mapWithKeys(function ($team) {
                        return [$team->id => ['status_team' => 6]];
                    })
                );
            }

            //ac customer
            $acCustomer = AcCustomer::find($request->ac_customer);
            // $next_service= Carbon::now()->addMonths(2);
            // if($acCustomer->next_service != null || $acCustomer->next_service != 0){
            //     $next_service = Carbon::now()->addDays($request->next_service);
            // }
            $acCustomer->update([
                'last_service' => now(),
                // 'next_service' => $next_service,
            ]);
            DB::commit();
            return redirect()->route('landing.showdetailac', $qr->url_unique)->with('toast_success', 'Service berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function upload_work_order(Order $id, Request $request)
    {
        $imagePath = null;
        if ($request->file('work_order')) {
            // Validate the form data
            $imagePath = uploadFile('work_order', 'public/images/orders/work_order', null, false, 'work_order');
        }
        $id->work_order = $imagePath;
        $id->save();
        return to_route('technician.orderDetail', $id->id)->with('toast_success', 'Work Order Berhasil Di Upload');
    }

    public function select_repair_type(Request $request)
    {
        $type = $request->input('type');
        $data = [
            'repair_types' => RepairAttachment::all(),
        ];
        return view('page_teknisi.select_repair_type', $data);
    }

    public function create_repair_document(Request $request)
    {
        $type = $request->input('type');
        $order = $request->input('order_id');
        $repair_type = RepairAttachment::findOrFail($type);
        $order = Order::findOrFail($order);
        $data = [
            'repair_type' => $repair_type,
            'order' => $order,
        ];
        return view('page_teknisi.create_repair_document', $data);
    }

    public function store_repair_document(Request $request)
    {
        try {
            DB::beginTransaction();

            // Create a new RepairAttachmentDocument instance
            $repair_document = new RepairAttachmentDocument;
            $repair_document->repair_attachment_id = $request->repair_attachment_id;
            $repair_document->order_id = $request->order_id;
            $repair_document->save();

            // Iterate over the repairs array
            foreach ($request->repairs as $item) {
                // Check if the array contains the required keys
                if (isset($item['repair_attachment_item_id']) && isset($item['image'])) {
                    // Store the uploaded image
                    $image = $item['image']; // Get the uploaded image from the request

                    // Generate a unique filename
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();

                    // Store the image in the specified directory
                    $image->storeAs('public/images/repair_attachment_document_detail', $filename);

                    // Create and save the RepairAttachmentDocumentDetail instance
                    $document_detail = new RepairAttachmentDocumentDetail();
                    $document_detail->repair_attachment_document_id = $repair_document->id;
                    $document_detail->repair_attachment_item_id = $item['repair_attachment_item_id'];
                    $document_detail->image = asset('storage/images/repair_attachment_document_detail/' . $filename);
                    $document_detail->save();
                }
            }

            // Commit the transaction
            DB::commit();

            // Redirect to the technician.orderDetail route with a success message
            return redirect()->route('technician.orderDetail', ['id' => $request->order_id])->with('toast_success', 'Revisi Order Berhasil');
        } catch (\Throwable $th) {
            // Roll back the transaction if an error occurs
            DB::rollBack();
            // Log the error
            dd($th);
            // Redirect back with an error message
            return redirect()->back()->with('toast_error', 'Failed To Create');
        }
    }



    public function show_repair_document(RepairAttachmentDocument $id)
    {
        $data = [
            'doc' => $id,
        ];

        return view('page_teknisi.repair_document_detail', $data);
    }
    public function edit_repair_document(RepairAttachmentDocument $id)
    {

        $data = [
            'repair_document_id' => $id,
            'order' => $id->order,
            'repair_type' => $id->repair_type
        ];

        return view('page_teknisi.edit_repair_document', $data);
    }

    public function update_repair_document(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            // Retrieve the existing repair document if available
            $repair_document = RepairAttachmentDocument::findOrFail($request->id);

            // Update the existing repair document
            $repair_document->repair_attachment_id = $request->repair_attachment_id;
            $repair_document->order_id = $request->order_id;
            $repair_document->save();



            // Iterate over the repairs array
            foreach ($request->repairs as $item) {
                if (isset($item['repair_attachment_item_id']) && isset($item['image'])) {
                    // Delete existing repair details associated with the document

                    // Store the uploaded image
                    $image = $item['image']; // Get the uploaded image from the request

                    // Generate a unique filename
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();

                    // Store the image in the specified directory
                    $image->storeAs('public/images/repair_attachment_document_detail', $filename);

                    RepairAttachmentDocumentDetail::where('id', $item['id'])->delete();
                    // Create and save the RepairAttachmentDocumentDetail instance
                    $document_detail = new RepairAttachmentDocumentDetail();
                    $document_detail->repair_attachment_document_id = $repair_document->id;
                    $document_detail->repair_attachment_item_id = $item['repair_attachment_item_id'];
                    $document_detail->image = asset('storage/images/repair_attachment_document_detail/' . $filename);
                    $document_detail->save();
                }
            }

            // Commit the transaction
            DB::commit();

            // Redirect to the technician.orderDetail route with a success message
            return redirect()->route('technician.orderDetail', ['id' => $repair_document->order_id])->with('toast_success', 'Revisi Order Berhasil');
        } catch (\Throwable $th) {
            // Roll back the transaction if an error occurs
            DB::rollBack();
            // Log the error
            \Log::error($th);
            // Redirect back with an error message
            return redirect()->back()->with('toast_error', 'Failed To Update');
        }
    }

    public function check_in($id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = OrderStatus::TEKNISI_DALAM_PERJALANAN;
        $order->save();
        return redirect()->back()->with('toast_success', 'Success To Update Status');
    }
    public function add_ac_detail($id)
    {
    }
    public function update_start_work($id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = OrderStatus::DALAM_PENGERJAAN_TEKNISI;
        $order->save();
        return redirect()->route('technician.orderDetail', ['id' => $id])->with('toast_success', 'Success To Update Status');
    }

    public function pending_order($id, Request $request)
    {
        try {
            $this->validate($request, [
                'reason' => 'required',
                'reasonDescription' => 'required',
            ]);
            // dd($request->all());
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            //update detail pending
            DetailPendingOrder::create([
                'order_id' => $order->id,
                'alasan' => $request->reason,
                'deskripsi' => $request->reasonDescription
            ]);


            $order->order_status = OrderStatus::PENDING_ORDER;
            $order->save();


            DB::commit();
            return redirect()->route('technician.orderDetail', $id)->with('toast_success', 'Success To Update');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'Failed To Update');
        }
    }
    public function upload_image_before(Order $order, MasterQr $qr)
    {

        // $services
        $order_ac = OrderDetail::where([
            'order_id' => $order->id,
            'ac_customer_id' => $qr->master_ac_customer_id,
            'order_detail_status' => 2
        ])->get();
        $data = [
            'order' => $order,
            'qr' => $qr,
            'order_ac' => $order_ac,
            // 'service'
            // 'activities' => $service=>repairAttachment::where('image_capture_time', 0)->get()
        ];
        // dd($data);
        return view('page_teknisi.update_order.upload_image_before_execute', $data);
    }

    public function store_image_before($id, $id_image,Request $request){

        $filename = null;
        if ($request->file('file')) {
            // Validate the form data
            $filename = uploadFile('file', 'public/images/orders/location', null , false, 'image_before_' . date('dmYHis') );
        }
        if(!empty($filename)){
            $store=[
                'order_detail_id' => $id,
                'attachment_id' => $id_image,
                'image' => $filename,
                'notes' => 'before',
            ];
            OrderDetailAttachment::create($store);
            return response()->json(['success' => $filename]);
        }
        return response()->json(['error' => 'File not found'], 404);
    }
    public function upload_image_after(Order $order, MasterQr $qr)
    {

        // $services
        $order_ac = OrderDetail::where([
            'order_id' => $order->id,
            'ac_customer_id' => $qr->master_ac_customer_id,
            'order_detail_status' => 2
        ])->get();
        $data = [
            'order' => $order,
            'qr' => $qr,
            'order_ac' => $order_ac,
            // 'service'
            // 'activities' => $service=>repairAttachment::where('image_capture_time', 0)->get()
        ];
        // dd($data);
        return view('page_teknisi.update_order.upload_image_after_execute', $data);
    }

    public function store_image_after($id, $id_image,Request $request){

        $filename = null;
        if ($request->file('file')) {
            // Validate the form data
            $filename = uploadFile('file', 'public/images/orders/location', null , false, 'image_after_' . date('dmYHis') );
        }
        if(!empty($filename)){
            $store=[
                'order_detail_id' => $id,
                'attachment_id' => $id_image,
                'image' => $filename,
                'notes' => 'after',
            ];
            OrderDetailAttachment::create($store);
            return response()->json(['success' => $filename]);
        }
        return response()->json(['error' => 'File not found'], 404);
    }

    public function view_image_before(Order $order, MasterQr $qr){
        $order_ac = OrderDetail::where([
            'order_id' => $order->id,
            'ac_customer_id' => $qr->master_ac_customer_id,
            'order_detail_status' => 2
        ])->get();
        $data=[
            'order' => $order,
            'qr' => $qr,
            'order_ac' => $order_ac,
        ];
        return view('page_teknisi.update_order.view_image', $data);
    }

    public function edit_order($id)
    {
        $order = Order::findOrFail($id);
        $services = Service::all();
        $data = [
            'order' => $order,
            'statusorder' => OrderStatus::getDescriptionArray(),
            'services' => $services
        ];

        return view('page_teknisi.update_order.edit_order', $data);
    }
    public function update_order($id, Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
                $service = Service::whereIn('id', $request->service)->get();
                // dd($service);
                $detail=array();
                $sub_total=0;
                foreach ($service as $key => $value) {
                    $price= $value->price * $request->jumlah[$value->id];
                    for($i=0; $i < $request->jumlah[$value->id]; $i++){
                        $detail[]=[
                            'team_id' => auth()->guard('technician')->user()->teams->first()->id,
                            'base_price' => $value->price,
                            'service_id' => $value->id,
                            'order_id' => $id,
                            'sub_total' => $value->price,
                            'order_detail_status' => 1
                        ];
                    }
                    $sub_total += $price;
                }
                // dd($detail);
                $order = Order::findOrFail($id);
                $order->total_base_price = $sub_total;
                $order->sub_total = $order->transport_fee + $sub_total;
                $order->grand_total = $order->sub_total - $order->diskon;
                $order->save();
                $order->order_details()->delete();
                $order->order_details()->createMany($detail);
            DB::commit();
            return redirect()->route('technician.orderDetail',$order->id)->with('toast_success', 'Success To Update');
        }
        catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'Failed To Update');
        }
    }

    public function update_service($id)
    {
        $order = Order::findOrFail($id);
        $services = Service::all();
        $data = [
            'order' => $order,
            'services' => $services
        ];

        return view('page_teknisi.update_order.update_service', $data);
    }

    // public function upload_image_after($id)
    // {
    //     $order = Order::findOrFail($id);
    //     // $services
    //     $data = [
    //         'order' => $order,
    //         // 'service'
    //         // 'activities' => Service::where('pk', $id)->get()
    //     ];

    //     return view('page_teknisi.update_order.upload_image_after_execute', $data);
    // }
    public function upload_location_image($id, Request $request)
    {

        $order = Order::findOrFail($id);
        $filename = null;
        if ($request->file('file')) {
            // Validate the form data
            $filename = uploadFile('file', 'public/images/orders/location', $order->location_image, false, 'location' . $order->order_code);
        }
        $order->location_image = $filename;
        $order->save();
        return response()->json(['success' => $filename]);
    }

    public function detail_ac_order(Order $order, MasterQr $qr)
    {

        $data = [
            'order' => $order
        ];
        return view('page_teknisi.update_order.update_service', $data);
    }

    public function add_service_ac(Order $order, MasterQr $qr){
        // dd($order);
        $data = [
            'order' => $order,
            'qr' => $qr

        ];
        return view('page_teknisi.update_order.update_service', $data);
    }

    public function store_service_ac(Request $request, Order $order, MasterQr $qr){

        try {
            DB::beginTransaction();
                $this->validate($request, [
                    'service' => 'required',
                ]);
                $team = auth()->guard('technician')->user()->teams->first()->id;
                $update = [
                    'order_detail_status' => 2,
                    'team_id' => $team,
                    'ac_customer_id' => $qr->ac_customer->id,
                    'date_complete' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                OrderDetail::whereIn('id', $request->service)->where('order_detail_status', 1)->update($update);
                $data = OrderDetail::where(['order_id' => $order->id, 'order_detail_status' => 1])->count();
                // dd($data);
                if ($data <= 0) {
                    $order->update(['order_status' => 6]);
                    $order->teams()->update(['status' => 0]);

                    $order->teams()->syncWithoutDetaching(
                        $order->teams->mapWithKeys(function ($team) {
                            return [$team->id => ['status_team' => 6]];
                        })
                    );
                }
                $acCustomer = AcCustomer::find($qr->ac_customer->id);
                $acCustomer->update([
                    'last_service' => now(),
                    // 'next_service' => $next_service,
                ]);
            DB::commit();
            return redirect()->route('technician.orderDetail', $order->id)->with('toast_success', 'Service berhasil ditambahkan');
        }
        catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error', 'Failed To Update');
        }

    }
}
