<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='ac_customers';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];

    public function order_details(){
        return $this->hasMany(OrderDetail::class,'ac_customer_id','id');
    }

    public function customer(){
        return $this->belongsTo(MasterCustomer::class, 'master_customer_id', 'id');
    }

    public function address(){
        return $this->belongsTo(MasterAddress::class, 'master_address_id', 'id');
    }
    public function master_qr(){
        return $this->belongsTo(MasterQr::class, 'master_qr_id', 'id');
    }

    public function ac(){
        return $this->belongsTo(MasterAc::class, 'master_ac_id', 'id');
    }

    public function getAcNameAttribute()
    {
        return $this->ac->ac_name;
    }

    public function getCustomerNameAttribute(){
        return $this->customer->nama;
    }

    public function getAddressCompletedAttribute(){
        return $this->address->completedAddress;
    }
}
