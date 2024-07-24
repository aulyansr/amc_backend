<?php

namespace App\Http\Controllers;

use App\Models\AcCustomer;
use App\Models\Branch;
use App\Models\MasterAddress;
use App\Models\MasterCustomer;
use App\Models\MasterTransportFee;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServicesGroup;
use App\Models\Subscription;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Indonesia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AjaxController extends Controller
{
    public function get_kota()
    {
        $province_id = request('province_id');
        $kota = Indonesia::findProvince($province_id, ['cities'])->cities->sortBy('name')->pluck('name', 'id');

        return view('region.list_kota', compact('kota'));
    }

    public function get_kecamatan()
    {
        $city_id = request('city_id');
        $kecamatan = Indonesia::findCity($city_id, ['districts'])->districts->sortBy('name')->pluck('name', 'id');

        return view('region.list_kecamatan', compact('kecamatan'));
    }

    public function get_kelurahan()
    {
        $kecamatan_id = request('kecamatan_id');
        $kelurahan = Indonesia::findDistrict($kecamatan_id, ['villages'])->villages->sortBy('name')->pluck('name', 'id');

        return view('region.list_kelurahan', compact('kelurahan'));
    }

    public function get_customer(Request $request)
    {

        $search = $request->search;
        $customers = MasterCustomer::orderBy('nama', 'asc')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->get(['nama', 'id', 'type', 'company_name'])
            ->map(function ($customer) {
                $nama = $customer->type == '1' ? $customer->company_name : $customer->nama;
                return [
                    'id' => $customer->id,
                    'text' => $nama,
                    'type' => $customer->type
                ];
            })
            ->values()
            ->toArray();

        return response()->json($customers);
    }

    public function get_address_by_customer(Request $request)
    {
        $search = $request->search;
        $customerID = $request->customer_id;
        if (empty($customerID)) {
            return response()->json([]);
        }
        $addresses = MasterAddress::orderBy('address_name', 'asc')
            ->when($search, function ($query) use ($search) {
                $query->where('address_name', 'like', '%' . $search . '%');
            })
            ->when($customerID, function ($query) use ($customerID) {
                $query->where('master_customer_id', $customerID);
            })
            ->get()
            ->map(function ($address) {
                return [
                    'id' => $address->id,
                    'text' => $address->address_name,
                    'address' => $address->CompletedAddress,
                    'lat' => $address->latitude,
                    'lng' => $address->longitude,
                ];
            })
            ->values()
            ->toArray();

        return response()->json($addresses);
    }
    public function get_service(Request $request)
    {
        $search = $request->search;
        if (empty($request->service_group)) {
            return response()->json([]);
        }
        if (!empty($request->subscription)) {
            $subscription = Subscription::find($request->subscription);
            $paket = $subscription->paket;
            $service = $paket->services()->where('is_active', 1)
                ->when($search, function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->get(['id', 'name', 'price', 'max_discount'])
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'text' => $item->name,
                        'price' => $item->price,
                        'price_warranty' => $item->price_warranty,
                        'max_discount' => $item->max_discount,
                    ];
                })
                ->values()
                ->toArray();
        } else {
            $serviceGroupId = $request->service_group;
            $customers = MasterCustomer::find($request->customer_id);
            if ($request->type == 1 || $request->type == 2) {
                $service = Service::orderBy('name', 'asc')
                    ->where('is_active', 1)
                    ->where('master_customer_id', $request->customer_id)
                    ->when($search, function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->whereHas('service_type.services_group', function ($query) use ($serviceGroupId) {
                        $query->where('id', $serviceGroupId);
                    })
                    ->get(['id', 'name', 'price', 'max_discount'])
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'text' => $item->name,
                            'price' => $item->price,
                            'max_discount' => $item->max_discount,
                        ];
                    })
                    ->values()
                    ->toArray();
            } else {
                $service = Service::orderBy('name', 'asc')
                    ->where('is_active', 1)
                    ->whereNull('master_customer_id')
                    ->whereNull('paket_id')
                    ->when($search, function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->whereHas('service_type.services_group', function ($query) use ($serviceGroupId) {
                        $query->where('id', $serviceGroupId);
                    })
                    ->get(['id', 'name', 'price', 'max_discount'])
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'text' => $item->name,
                            'price' => $item->price,
                            'max_discount' => $item->max_discount,
                        ];
                    })
                    ->values()
                    ->toArray();
            }
        }

        return response()->json($service);
    }

    public function get_teams_available(Request $request)
    {
        $search = $request->search;
        $teams = Team::orderBy('nama', 'asc')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->pluck('nama', 'id')
            ->map(function ($nama, $id) {
                return ['id' => $id, 'text' => $nama];
            })
            ->values()
            ->toArray();

        return response()->json($teams);
    }

    public function get_service_counts(Request $request)
    {
        $order = Order::find($request->order_id);
        return response()->json($order->serviceCountsWithStatus);
    }

    public function get_customer_subscription(Request $request)
    {
        $search = $request->search;
        $customerID = $request->customer_id;
        if (empty($customerID)) {
            return response()->json([]);
        }
        $subscription = Subscription::orderBy('start_date', 'asc')
            ->when($search, function ($query) use ($search) {
                $query->where('code', 'like', '%' . $search . '%');
            })
            ->when($customerID, function ($query) use ($customerID) {
                $query->where('master_customer_id', $customerID);
            })
            ->where('status', 'BELUM_SELESAI')
            ->where('expired_date', '>=', date('Y-m-d'))
            ->pluck('code', 'id')
            ->map(function ($nama, $id) {
                return ['id' => $id, 'text' => $nama];
            })
            ->values()
            ->toArray();

        return response()->json($subscription);
    }

    public function get_customer_b2b2c(Request $request)
    {
        $search = $request->search;
        $customerID = $request->customer_id;

        $customers = MasterCustomer::where('partner_id', $customerID)
            ->when($search, function ($query) use ($search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->pluck('nama', 'id')
            ->map(function ($nama, $id) {
                return ['id' => $id, 'text' => $nama];
            })
            ->values()
            ->toArray();


        return response()->json($customers);
    }

    function get_distance(Request $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        $branch = Branch::all();
        $distances = [];
        foreach ($branch as $b) {
            $address = "https://api.distancematrix.ai/maps/api/distancematrix/json?origins={$b->latitude}, {$b->longitude}&destinations={$lat}, {$lng}&key=" . env('DISTANCE_MATRIX_KEY');
            $response = Http::get($address);
            if ($response->successful()) {
                $data = $response->json();
                $distances[$b->id]['lat'] = $b->latitude;
                $distances[$b->id]['lng'] = $b->longitude;
                $distances[$b->id]['distance'] = round($data['rows'][0]['elements'][0]['distance']['value'] / 1000);
                $distances[$b->id]['duration'] = round($data['rows'][0]['elements'][0]['duration']['value'] / 60);
            } else {
                $error = $response->clientError() ? 'Client Error' : 'Server Error';
                // Handle the error
                return ['status' => false, 'error' => $error];
            }
        }
        $smallestDistance = min(array_column($distances, 'distance'));
        $filteredDistances = array_filter($distances, function ($item) use ($smallestDistance) {
            return $item['distance'] == $smallestDistance;
        });
        return json_encode(['status' => true, 'data' => $filteredDistances]);
    }

    function get_count_distance(Request $request)
    {
        try {
            // Make API request
            $validatedData = $request->validate([
                'cabang_id' => 'required',
                'customer_address_id' => 'required',
            ]);
            if ($request->cabang_id == 0 || $request->customer_address_id == 0) {
                return response()->json(['error' => 'Cabang dan Alamat Tidak Boleh Kosong'], 400);
            }
            $cabang = Branch::find($request->cabang_id);
            $customer_address = MasterAddress::find($request->customer_address_id);
            // dd($cabang);
            $distance = getDistance($cabang->latitude . ',' . $cabang->longitude, $customer_address->latitude . ',' . $customer_address->longitude);
            $jarak = $distance['rows'][0]['elements'][0]['distance']['value'] / 1000;
            $transport_fee = MasterTransportFee::where('distance_from', '<=', $jarak)
                ->where('distance_to', '>=', $jarak)->first();
            $data = [
                'distance' => $jarak,
                'price' => $transport_fee->distance_price
            ];
            return response()->json($data);
        } catch (Exception $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }

    public function get_schedule_order_resource()
    {
        // Fetch active teams
        $teams = Team::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $resources = [];
        foreach ($teams as $team) {
            $resources[] = [
                'id' => $team->id,
                'title' => $team->nama,
            ];
        }

        return response()->json($resources);
    }

    // {
    //     $resources = [
    //         ['id' => "a", 'title' => "Auditorium A"],
    //         ['id' => "b", 'title' => "Auditorium B"],
    //         ['id' => "c", 'title' => "Auditorium C"]
    //     ];
    //     return response()->json($resources);
    // }


    public function get_schedule_order_event()
    {
        // Fetch all active teams
        $teams = Team::where('is_active', true)->get();

        $events = [];

        // Loop through each team
        foreach ($teams as $team) {
            // Fetch orders for the current team
            $orders = $team->orders()->get();

            // Loop through each order
            foreach ($orders as $order) {
                // Determine the customer type
                if ($order->partner_id !== null) {
                    $type = "Customer Gree";
                } elseif ($order->customer->type == 1) {
                    $type = "B2B";
                } else {
                    $type = "B2C";
                }

                $bookedDate = Carbon::parse($order->booked_date);
                $endDate = $bookedDate->copy()->addHours(2);

                // Format each order as an event
                $events[] = [
                    'id' => $order->id,
                    'resourceId' => $team->id, // Use the team ID as the resource ID
                    'title' => "{$order->customer->nama}, {$type}", // Customer name and type
                    'start' => $bookedDate->format('Y-m-d H:i:s'), // Format the start date
                    'end' => $endDate->format('Y-m-d H:i:s'), // Adding 2 hours to the booked_date
                    'color' => "#ffc35a", // Customize this as needed
                    'url' => route('orders.show', $order->id),
                ];
            }
        }

        return response()->json($events);
    }





    function get_schedule_order_by_customer($id)
    {
        $scheduleData = Order::with('teams')
            ->whereBetween('order_status', [1, 5])
            ->where('master_customer_id', $id)
            ->get();
        $next_service = AcCustomer::where('master_customer_id', $id)->get();
        $events = [];
        $teams_color = [];
        foreach ($scheduleData as $order) {
            $nama_team = "";
            $no = 0;

            foreach ($order->teams as $team) {
                if (!array_key_exists($team->id, $teams_color)) {
                    $color = getRandomColor(); // Generate a random color
                    $teams_color[$team->id] = $color; // Store the color for the team
                }
                $nama_team .= $team->nama;
                if ($order->teams->count() - 1 != $no) {
                    $nama_team .= ', ';
                }
                $no++;
            }
            $events[] = [
                'title' => $nama_team,
                'start' => $order->booked_date,
                'url' => route('orders.show', $order->id),
                'color' => '#48c38f',
            ];
        }
        foreach ($next_service as $next) {
            $events[] = [
                'title' => $next->address->address_name,
                'start' => $next->next_service,
                'url' => route('master.qrgenerate.show', $next->master_qr->url_unique),
                'color' => '#3e75e2',
            ];
        }
        // dd($events);
        // dd($events);
        // Return the event data as JSON
        //   header('Content-Type: application/json');
        return response()->json($events);
    }

    function get_service_group(Request $request)
    {
        $search = $request->search;
        $subscription = ServicesGroup::orderBy('name', 'asc')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->where('is_active', '1')
            ->pluck('name', 'id')
            ->map(function ($nama, $id) {
                return ['id' => $id, 'text' => $nama];
            })
            ->values()
            ->toArray();

        return response()->json($subscription);
    }

    public function get_service_spare_part(Request $request){
        $service_id = $request->service_id;
        $service = Service::find($service_id);
        return response()->json($service->spare_part);
    }
}
