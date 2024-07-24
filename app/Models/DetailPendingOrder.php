<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPendingOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table      = 'detail_pending_order';
    protected $primaryKey = 'id';
    public    $timestamps = true;

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
