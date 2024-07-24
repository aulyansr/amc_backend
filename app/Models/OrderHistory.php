<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHistory extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $table = 'order_histories';
    protected $primaryKey = 'id';
    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function teams(){
        return $this->belongsToMany(Team::class,'team_order','order_id','team_id')->withPivot(['status_team'])->withTimestamps();
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function address(){
        return $this->belongsTo(MasterAddress::class,'master_address_id','id');
    }

    public function customer(){
        return $this->belongsTo(MasterCustomer::class,'master_customer_id','id');
    }

    public function order_details(){
        return $this->hasMany(OrderDetailHistory::class, 'order_history_id','id');
    }
    public function getServiceCountsAttribute()
    {
        return $this->order_details->groupBy('service_id')->map(function ($items) {
            return [
                'count' => $items->count(),
                'service_name' => $items->first()->service()->withTrashed()->first()->name,
                'price' => $items->first()->base_price,
                'sub_total' => $items->first()->sub_total,
                'service_id'=>$items->first()->service_id
            ];
        });
    }
    public function getServiceCountsWithStatusAttribute()
    {
        return $this->order_details->where('order_detail_status', 1)->groupBy('service_id')->map(function ($items) {
            return [
                'count' => $items->count(),
                'service_name' => $items->first()->service->name,
                'order_detail_id' => $items->first()->id
            ];
        });
    }

    public function getTeamCountsAttribute()
    {
        return $this->teams->groupBy('team_order.status_team');
    }
    public function scopeTotalOrderThisMonth(){
        return $this->whereMonth('booked_date', Carbon::now()->month)->count();
    }
    public function scopeTotalAllOrder(){
        return $this->where('order_status','!=',0)->count();
    }
    public function getStatusPaymentAttribute(){
        $status = OrderStatus::getPaymentDescriptionArray();
        return $status[$this->payment_status];
    }
}
