<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    public function order_history()
    {
        return $this->hasMany(OrderHistory::class, 'order_id', 'id');
    }
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_order', 'order_id', 'team_id')->withPivot(['status_team'])->withTimestamps();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(MasterAddress::class, 'master_address_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(MasterCustomer::class, 'master_customer_id', 'id');
    }
    public function customer_b2b2c()
    {
        return $this->belongsTo(MasterCustomer::class, 'customer_b2b2c_id', 'id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
    public function detail_pending_order()
    {
        return $this->hasMany(DetailPendingOrder::class, 'order_id', 'id');
    }
    public function service_group()
    {
        return $this->belongsTo(ServicesGroup::class, 'service_group_id', 'id');
    }
    public function getServiceCountsAttribute()
    {
        return $this->order_details->groupBy('service_id')->map(function ($items) {
            $firstItem = $items->first();
            $service = $firstItem->service()->withTrashed()->first();
            $serviceType = $service ? $service->service_type : null;

            return [
                'count' => $items->count(),
                'service_name' => $service ? $service->name : ' - ',
                'service_type' => $serviceType ? $serviceType->name : '-',
                'ac_name' => $firstItem->master_ac ? $firstItem->master_ac->ac_name : '-',
                'price' => $firstItem->base_price,
                'sub_total' => $firstItem->sub_total,
                'service_id' => $firstItem->service_id,
                'max_discount' => $service ? $service->max_discount : 0,
                'discount' => $items->sum('discount'),
                'total_service' => $items->sum('sub_total'),
            ];
        });
    }
    public function getServiceCountsWithStatusAttribute()
    {
        return $this->order_details->where('order_detail_status', 1)->groupBy('service_id')->map(function ($items) {
            return [
                'count' => $items->count(),
                'service_name' => $items->first()->service()->withTrashed()->first()->name,
                'order_detail_id' => $items->first()->id
            ];
        });
    }
    public function getTeamCountsAttribute()
    {
        return $this->teams->groupBy('team_order.status_team');
    }
    public function scopeTotalOrderThisMonth()
    {
        return $this->whereMonth('booked_date', Carbon::now()->month)->count();
    }
    public function scopeTotalAllOrder()
    {
        return $this->where('order_status', '!=', 0)->count();
    }
    public function getStatusPaymentAttribute()
    {
        $status = OrderStatus::getPaymentDescriptionArray();
        return $status[$this->payment_status];
    }

    public function spare_part()
    {
        return $this->hasMany(OrderSparePartDetail::class, 'order_id', 'id');
    }
}
