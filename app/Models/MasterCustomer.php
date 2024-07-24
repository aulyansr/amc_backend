<?php

namespace App\Models;

use App\Enums\CustomerType;
use App\Traits\SelfReferenceTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCustomer extends Model
{
    use HasFactory, SoftDeletes, SelfReferenceTrait;
    protected $table      = 'master_customers';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded = [];
    protected $hidden = [
        'pin',
    ];

    // public function setPhoneAttribute($value)
    // {
    //     // Remove any non-digit characters
    //     $phone = preg_replace('/[^0-9]/', '', $value);

    //     // Check if the phone number starts with '0'
    //     if (substr($phone, 0, 1) === '0') {
    //         // Replace the first '0' with '62'
    //         $phone = '62' . substr($phone, 1);
    //     }

    //     $this->attributes['phone'] = $phone;
    // }

    /**
     * Get all of the masterQr for the MasterCustomer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function masterQr(): HasMany
    {
        return $this->hasMany(MasterQr::class, 'customer_id', 'id');
    }
    public function masterAddress(): HasMany
    {
        return $this->hasMany(MasterAddress::class, 'master_customer_id', 'id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'master_customer_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'master_customer_id', 'id');
    }
    public function getCustomerTypeAttribute()
    {
        return CustomerType::getDescriptionArray();
    }
    public function acCustomers(): HasMany
    {
        return $this->hasMany(AcCustomer::class, 'master_customer_id', 'id');
    }

}
