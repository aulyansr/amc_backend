<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparePartGroup extends Model
{
    use HasFactory, SoftDeletes;
    protected $table      = 'spare_part_group';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];

    public function spare_part(){
        return $this->hasMany(SparePart::class,'spare_part_group_id','id');
    }
}
