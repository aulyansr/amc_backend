<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Team;
use App\Models\Technician;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Order::with('customer', 'address', 'branch', 'order_details')->orderBy('booked_date', 'desc');
        $totalOrder = $query->count();
        $orders = $query->limit(10)->get();
        $orders->each(function ($order) {
            $order->serviceCounts = $order->getServiceCountsAttribute();
        });
        $totalOrderThisMonth = Order::whereBetween('booked_date', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();
        $totalCustomerThisMonth = MasterCustomer::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();
        $totalIncome = Order::where('payment_status', OrderStatus::LUNAS)->whereBetween('booked_date', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->sum('grand_total');

        $totalIncomeThisMonth = Order::where('payment_status', OrderStatus::LUNAS)->whereBetween('booked_date', [
            now()->startOfMonth(), now()->endOfMonth(),
        ])->sum('grand_total');
        $totalIncomeLastMonth = Order::where('payment_status', OrderStatus::LUNAS)->whereBetween('booked_date', [
            now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth(),
        ])->sum('grand_total');
        $totalIncomeLastTwoMonth = Order::where('payment_status', OrderStatus::LUNAS)->whereBetween('booked_date', [
            now()->subMonth(2)->startOfMonth(), now()->subMonth(2)->endOfMonth(),
        ])->sum('grand_total');
        // Get top customers
        $topCustomers = MasterCustomer::withCount('orders')
            ->orderByDesc('orders_count')
            ->limit(5)
            ->get();


        // Get top technicians
        $topTechnicians = Technician::with(['teams' => function ($query) {
            $query->with(['orders' => function ($query) {
                $query->select('orders.id', 'team_order.team_id');
            }])->withCount('orders');
        }])
            ->select('technicians.fullname as technician_name', 'teams.nama as team_name', DB::raw('COUNT(orders.id) as order_count'))
            ->join('team_technician', 'technicians.id', '=', 'team_technician.technician_id')
            ->join('teams', 'team_technician.team_id', '=', 'teams.id')
            ->join('team_order', 'teams.id', '=', 'team_order.team_id')
            ->join('orders', 'team_order.order_id', '=', 'orders.id')
            ->groupBy('technicians.id', 'teams.id')
            ->orderByDesc('order_count')
            ->limit(5)
            ->get();
        $workingTeams = Team::where('status', '1')->get();
        // Prepare data for the view
        $data = [
            'orders' => $orders,
            'statusorder' => OrderStatus::getDescriptionArray(),
            'array_status' => OrderStatus::getStatus(),
            'totalOrder' => $totalOrder,
            'totalOrderThisMonth' => $totalOrderThisMonth,
            'totalCustomerThisMonth' => $totalCustomerThisMonth,
            'totalIncome' => $totalIncome,
            'topCustomers' => $topCustomers,
            'topTechnicians' => $topTechnicians,
            'workingTeams' => $workingTeams,
            'totalIncomeThisMonth' => $totalIncomeThisMonth,
            'totalIncomeLastMonth' => $totalIncomeLastMonth,
            'totalIncomeLastTwoMonth' => $totalIncomeLastTwoMonth,
        ];

        // Render the view with the data
        return view('home', $data);
    }
}
