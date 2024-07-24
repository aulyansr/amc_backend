<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Enums\SubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\MasterCustomer;
use App\Models\Paket;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:subscription-list|subscription-create|subscription-edit|subscription-delete|subscription-payment|subscription-assignteam', ['only' => ['index','show']]);
         $this->middleware('permission:subscription-create', ['only' => ['create','store']]);
         $this->middleware('permission:subscription-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:subscription-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $subscription = Subscription::latest()->get();
        $status= SubscriptionStatus::getDescriptionArray();

        return view('subscription.index', compact('subscription','status'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data=[
            'paket'=>Paket::where('status',1)->pluck('nama_paket','id'),
        ];
        return view('subscription.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request)
    {
        $paket=Paket::find($request->paket);
        $insert=[
            'master_customer_id' => $request->customer,
            'code' => $request->code,
            'name' => $paket->nama_paket,
            'start_date' => date('Y-m-d'),
            'price_total' => resetNumberFormat($paket->harga_paket),
            'amount_subscription' => resetNumberFormat($paket->jumlah_ac),
            'tipe'=>$paket->masa_berlaku,
        ];
        if($paket->masa_berlaku == '3 bulan'){
            $insert['expired_date']=Carbon::now()->addMonths(3);
        }
        elseif($paket->masa_berlaku == '6 bulan'){
            $insert['expired_date']=Carbon::now()->addMonths(6);
        }
        elseif($paket->masa_berlaku == '1 Tahun'){
            $insert['expired_date']=Carbon::now()->addYear();
        }
        Subscription::create($insert);
        return to_route('subscription.index')->with('toast_success', 'Subscription created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        $status= SubscriptionStatus::getDescriptionArray();
        $statusorder= OrderStatus::getDescriptionArray();
        return view('subscription.show', compact('subscription','status','statusorder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        $customer=MasterCustomer::pluck('nama','id');
        $paket=Paket::where('status',1)->pluck('nama_paket','id');
        return view('subscription.edit', compact('subscription','customer','paket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, Subscription $subscription)
    {
        $paket=Paket::find($request->paket);
        $update=[
            'master_customer_id' => $request->customer,
            'code' => $request->code,
            'name' => $paket->nama_paket,
            'price_total' => resetNumberFormat($paket->harga_paket),
            'amount_subscription' => resetNumberFormat($paket->jumlah_ac),
            'tipe'=>$paket->masa_berlaku,
        ];
        if($paket->masa_berlaku == '3 bulan'){
            $update['expired_date']=Carbon::parse($subscription->start_date)->addMonths(3);
        }
        elseif($paket->masa_berlaku == '6 bulan'){
            $update['expired_date']=Carbon::parse($subscription->start_date)->addMonths(6);
        }
        elseif($paket->masa_berlaku == '1 Tahun'){
            $update['expired_date']=Carbon::parse($subscription->start_date)->addYear();
        }
        $subscription->update($update);
        return to_route('subscription.index')->with('toast_success', 'Subscription updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return to_route('subscription.index')->with('toast_success', 'Subscription deleted successfully');
    }
}
