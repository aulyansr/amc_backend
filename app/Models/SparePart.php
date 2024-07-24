<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparePart extends Model
{
    use HasFactory, SoftDeletes;
    protected $table      = 'spare_part';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];

    public function spare_part_group(){
        return $this->belongsTo(SparePartGroup::class,'spare_part_group_id','id');
    }

    public function services(){
        return $this->belongsToMany(Service::class,'service_spare_part','spare_part_id','service_id')->withPivot('price', 'price_warranty')->withTimestamps();
    }
}
