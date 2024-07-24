<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Mail\NewOrderMail;
use App\Models\MasterAddress;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\MasterCustomer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomerPageController extends Controller
{
    public function index(Request $request)
    {
        $current_customer = Auth::guard('customer')->user();
        $orders = $current_customer->orders()->limit(5)->orderBy('booked_date', 'desc')->get();
        $orderStatus = $request->input('order_status');
        // address

        $data = [
            'customer' => $current_customer,
            'orders' => $orders,
            'statusorder' => OrderStatus::getDescriptionArray(),
        ];
        if (Auth::guard('customer')->user()->type == 1) {
            $data['suggest_service'] = $current_customer->masterAddress()->whereHas('ac_customer', function ($query) {
                $query->where('next_service', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'));
            })->withCount(['ac_customer' => function ($query) {
                $query->where('next_service', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'));
            }])->get();
            return view('page_customer.index_corpo', $data);
        } else {
            return view('page_customer.index', $data);
        }
    }

    public function create_order(Request $request)
    {
        $current_customer = Auth::guard('customer')->user();
        $address = $current_customer->masterAddress()->where('is_main', 1)->first();
        $data = [
            'customer' => $current_customer,
            'main_address' => $address,
        ];
        return view('page_customer.create_order', $data);
    }

    public function order_detail($ordercustomer)
    {
        $current_customer = Auth::guard('customer')->user();
        $order = Order::find($ordercustomer);
        $data = [
            'customer' => $current_customer,
            'order' => $order,
            'statusorder' => OrderStatus::getDescriptionArray(),
        ];
        return view('page_customer.order_detail', $data);
    }

    public function list_order(Request $request)
    {
        $current_customer = Auth::guard('customer')->user();
        $orderStatus = $request->input('order_status');
        $all = $current_customer->orders()->orderBy('booked_date', 'desc')->get();
        $unpaid = $current_customer->orders()->where('order_status', 1);
        $on_progress = $current_customer->orders()->whereIn('order_status', [2, 3, 4, 5])->get();
        $orders_canceled = $current_customer->orders()
            ->where('order_status', 0)
            ->get();

        $orders_finish = $current_customer->orders()
            ->where('order_status', 6)
            ->get();
        $data = [
            'customer' => $current_customer,
            'all_order' => $all,
            'unpaid_order' => $unpaid,
            'on_progress_order' => $on_progress,
            'canceled' => $orders_canceled,
            'finish' => $orders_finish,
            'statusorder' => OrderStatus::getDescriptionArray(),
        ];
        return view('page_customer.list_order', $data);
    }

    public function list_ac(Request $request)
    {
        $current_customer = Auth::guard('customer')->user();
        $address = MasterAddress::query();
        $address = $address->where('master_customer_id', $current_customer->id);
        if (!empty($request->filter_alamat)) {
            $address = $address->where('id', $request->filter_alamat);
        }
        $address = $address->orderBy('address_name', 'asc');
        $address = $address->get();
        $data = [
            'customer' => $current_customer,
            'address' => $address,
        ];
        return view('page_customer.list_ac', $data);
    }


    public function store_order(Request $request)
    {
        try {
            DB::beginTransaction();
            $count = Order::withTrashed()->count();
            $orderCode = "TR-AMC-" . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
            $order = new Order;
            $order->booked_date = date('Y-m-d H:i', strtotime($request->input('booked_date')));
            $order->master_address_id = $request->input('master_address_id');
            $order->master_customer_id = Auth::guard('customer')->user()->id;
            $order->total_ac = resetNumberFormat($request->input('total_ac'));
            $order->total_base_price = resetNumberFormat($request->input('sub_total_service'));
            $order->reason = $request->input('reason');
            $order->location_range = 0;
            $order->transport_fee = 0;
            $order->sub_total = resetNumberFormat($request->input('grand_total'));
            $order->diskon = 0;
            $order->grand_total = resetNumberFormat($request->input('grand_total'));
            $order->order_status = 1;
            if (!empty($request->input('subscription'))) {
                $order->order_status = 2;
            }
            $order->order_method = 'Order by Customer';
            $order->order_code = $orderCode;
            $order->save();

            $services = [];
            $sum_service = 0;

            foreach ($request->input('services') as $service) {
                $sum_service += (int) $service['quantity'];
                for ($i = 1; $i <= (int) $service['quantity']; $i++) {
                    $insert = [
                        'order_id' => $order->id,
                        'service_id' => $service['service_id'],
                        'order_detail_status' => 1,
                        'base_price' => resetNumberFormat($service['harga']),
                        'sub_total' => resetNumberFormat($service['harga']),
                    ];
                    array_push($services, $insert);
                }
            }
            OrderDetail::insert($services);
            DB::commit();
            send_mail_to_cs($order);
            return to_route('customer.index', $order->id)->with('toast_success', 'Order Berhasil Ditambahkan');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('toast_error', 'Order Gagal Ditambahkan');
        }
    }

    public function store_address(Request $request)
    {
        $data = array(
            'master_customer_id' => Auth::guard('customer')->user()->id,
            'province_code' => $request->province_code,
            'city_code' => $request->city_code,
            'district_code' => $request->district_code,
            'village_code' => $request->village_code,
            'postal_code' => $request->postal_code,
            'address_detail' => $request->address_detail,
            'landmark' => $request->landmark,
            'address_name' => $request->address_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'jumlah_ac' => $request->jumlah_ac,
            'address_type' => $request->address_type,
            'time_open' => $request->time_open,
            'time_close' => $request->time_close
        );
        if (Auth::guard('customer')->user()->masterAddress()->count() == 0 || empty(Auth::guard('customer')->user()->masterAddress()->where('is_main', true)->first())) {
            $data['is_main'] = 1;
        }
        MasterAddress::create($data);
        return response()->json($data, 200);
    }

    public function profile()
    {
        $data = [
            'customer' => Auth::guard('customer')->user(),
        ];
        return view('page_customer.list_profile', $data);
    }

    public function change_profile()
    {
        return view('page_customer.change_profile');
    }
    public function update_profile(Request $request)
    {
        $data = array(
            'nama' => $request->name,
            'email' => $request->email,
        );
        Auth::guard('customer')->user()->update($data);
        return to_route('customer.profile.index')->with('toast_success', 'Profile Berhasil Diubah');
    }
    public function change_pin()
    {
        return view('page_customer.change_pin');
    }
    public function update_pin(Request $request)
    {
        $validatedData = $request->validate([
            'pin_lama' => 'required|digits:6',
            'pin_baru' => 'required|digits:6|different:pin_lama',
            'pin_baru_confirmed' => 'required|digits:6|same:pin_baru',
        ], [
            'pin_lama.required' => 'Pin Lama Tidak Boleh Kosong',
            'pin_baru.required' => 'Pin Baru Tidak Boleh Kosong',
            'pin_baru.different' => 'Pin Baru Tidak Boleh Sama Dengan Pin Lama',
            'pin_baru_confirmed.required' => 'Pin Baru Tidak Boleh Kosong',
            'pin_baru_confirmed.same' => 'Pin Baru Tidak Boleh Sama Dengan Pin Lama',
            'pin_lama.digits' => 'Pin Lama Harus 6 Angka',
            'pin_baru.digits' => 'Pin Baru Harus 6 Angka',
        ]);
        $current_customer = Auth::guard('customer')->user();
        if (!Hash::check($request->pin_lama, $current_customer->pin)) {
            return back()->with('toast_error', 'Pin Lama Tidak Cocok');
        }
        $current_customer->update([
            'pin' => Hash::make($request->pin_baru),
        ]);
        return view('page_customer.change_pin');
    }

    public function claim_warranty($id, Request $request){
        try {
            DB::beginTransaction();
                $originalOrder = Order::find($request->order_id);
                $numberClaim=Order::where('order_code', 'like', "%$originalOrder->order_code%")->count();
                //save Order
                $newOrder=$originalOrder->replicate();
                $newOrder->order_code=$originalOrder->order_code."-W".$numberClaim;
                $newOrder->payment_status=OrderStatus::LUNAS;
                $newOrder->total_base_price =0;
                $newOrder->transport_fee =0;
                $newOrder->sub_total =0;
                $newOrder->diskon =0;
                $newOrder->grand_total =0;
                $newOrder->order_method = 'Claim warranty by customer';
                $newOrder->is_warranty = 1;
                $newOrder->order_status = 7;
                $newOrder->created_by = NULL;
                $newOrder->booked_date = date('Y-m-d H:i:s');
                $newOrder->reason = 'Klaim Garansi '.$originalOrder->order_code;
                $newOrder->save();

                //save order_detail
                $orderDetail=OrderDetail::where('id', $id)->first();
                $newOrderDetail=$orderDetail->replicate();
                $newOrderDetail->order_id = $newOrder->id;
                $newOrderDetail->order_detail_status = 1;
                $newOrderDetail->base_price = 0;
                $newOrderDetail->discount = 0;
                $newOrderDetail->sub_total = 0;
                $newOrderDetail->warranty = NULL;
                $newOrderDetail->ac_customer_id = NULL;
                $newOrderDetail->team_id = NULL;
                $newOrderDetail->save();

                //save Team Order
                $newOrder->teams()->syncWithoutDetaching([
                    $orderDetail->team_id => ['status_team' => 3],
                ]);
            DB::commit();
            return to_route('customer.order_detail',hash_id($newOrder->id))->with('toast_success','Klaim Garansi Berhasil');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('toast_error','Gagal untuk klaim garansi');
        }

    }
    //    todo: create_address, list adress, order details
}
