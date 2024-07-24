<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='order_detail';
    public    $timestamps = true;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function master_ac()
    {
        return $this->belongsTo(AcCustomer::class, 'ac_customer_id', 'id');
    }

    public function orderDetailAttachments(){
        return $this->hasMany(OrderDetailAttachment::class, 'order_detail_id', 'id');
    }
    //shortcut data
    public function getActivitiesServicesAttribute(){
        return $this->service?->activities;
    }


}
