<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicesType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table      = 'services_type';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];

    public function services_group(){
        return $this->belongsTo(ServicesGroup::class,'services_group_id','id');
    }
    public function services(){
        return $this->hasMany(Service::class,'services_type_id','id');
    }
}
