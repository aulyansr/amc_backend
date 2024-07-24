<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderSparePartDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $table = 'order_spare_part_details';
    protected $primaryKey = 'id';

    public function spare_part()
    {
        return $this->belongsTo(SparePart::class, 'spare_part_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
