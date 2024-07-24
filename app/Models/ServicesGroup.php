<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicesGroup extends Model
{
    use HasFactory, SoftDeletes;
    protected $table      = 'services_group';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];

    public function services_type(){
        return $this->hasMany(ServicesType::class,'services_group_id','id');
    }
}
