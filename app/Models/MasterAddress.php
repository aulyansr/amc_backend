<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterAddress extends Model
{
    use HasFactory,SoftDeletes;
    protected $table      = 'master_addresses';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];

    public function province(){
        return $this->belongsTo(Province::class,'province_code','id');
    }
    public function city(){
        return $this->belongsTo(City::class,'city_code','id');
    }

    public function district(){
        return $this->belongsTo(District::class,'district_code','id');
    }

    public function village(){
        return $this->belongsTo(Village::class, 'village_code','id');
    }

    public function customer(){
        return $this->belongsTo(MasterCustomer::class,'master_customer_id','id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'master_address_id', 'id');
    }
    public function ac_customer(): HasMany
    {
        return $this->hasMany(AcCustomer::class,'master_address_id','id');
    }

    public function getCompletedAddressAttribute()
    {
        $landmark = $this->landmark ? ' (' . $this->landmark . ')' : '';
        return "{$this->address_detail} {$landmark}, " .
               Str::title($this->village->name) . ', ' .
               Str::title($this->district->name) . ', ' .
               Str::title($this->city->name) . ', ' .
               Str::title($this->province->name) . ', ' .
               $this->postal_code;
    }
    public function getCompletedNextServiceAttribute(){
        $data=convertDaysToMonthsWeeksDays($this->attributes['next_service']);
        $text='';
        if($data['months'] > 0){
            $text=$data['months'].' bulan';
        }
        if($data['weeks'] > 0){
            $text=$text.' '.$data['weeks'].' minggu';
        }
        if($data['days'] > 0){
            $text=$text.' '.$data['days'].' hari';
        }
        if($text==''){
            $text='Tidak ada next order otomatis';
        }
        return $text;
    }


}
