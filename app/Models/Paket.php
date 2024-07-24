<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paket extends Model
{
    use HasFactory,SoftDeletes;

    protected $table ='pakets';
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function serviceType(){
        return $this->belongsToMany(ServicesType::class, 'paket_type_services', 'paket_id','service_type_id');
    }
}
