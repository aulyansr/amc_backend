<?php

namespace App\Http\Controllers\Master;

use App\Enums\CustomerType;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterCustomerRequest;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerB2b2cController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($customer_id)
    {
        $data = array(
            'customer' => new MasterCustomer,
            'customer_id' => $customer_id,
            'customer_type' => CustomerType::getDescriptionArray(),
        );
        return view('customer_b2b2c.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($customer_id, MasterCustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $insert = array(
                'type' => $request->type,
                'company_name' => $request->company_name,
                'nama' => $request->nama,
                'email' => $request->email,
                'phone' => $request->phone,
                'partner_id' => $customer_id
            );
            $customer = MasterCustomer::create($insert);
            DB::commit();
            return redirect()->route('customers.address.create', $customer->id)->with('toast_success', 'Data Berhasil Disimpan');
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
    public function show(string $customer_id, MasterCustomer $data)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $customer_id, MasterCustomer $data)
    {
        $data = array(
            'customer' => $data,
            'customer_id' => $customer_id,
            'customer_type' => CustomerType::getDescriptionArray(),
        );
        return view('customer_b2b2c.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterCustomerRequest $request, $customer_id, MasterCustomer $data)
    {
        try {
            DB::beginTransaction();
            $insert = array(
                'type' => $request->type,
                'company_name' => $request->company_name,
                'nama' => $request->nama,
                'email' => $request->email,
                'phone' => $request->phone
            );
            $data->update($insert);
            DB::commit();
            return redirect()->route('customers.show', $customer_id)->with('toast_success', 'Data Berhasil Diubah');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->route('customers.index')->with('toast_error', 'Data Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $customer_id, MasterCustomer $data)
    {
        $data->delete();
        return redirect()->route('customers.show', $customer_id)->with('toast_success', 'Data Berhasil Dihapus');
    }
}
