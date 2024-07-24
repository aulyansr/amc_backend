<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetailHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='order_detail_histories';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public function order_history()
    {
        return $this->belongsTo(OrderHistory::class, 'order_history_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function master_ac()
    {
        return $this->belongsTo(AcCustomer::class, 'ac_customer_id', 'id');
    }
}
