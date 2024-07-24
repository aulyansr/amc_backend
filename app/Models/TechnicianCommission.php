<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicianCommission extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'technician_commission';
    protected $primaryKey = 'id';
    // Catatan Status Komisi
    // 1 tambah komisi
    // 2 kurang komisi
    // 3 perbaikan tambah
    // 4 perbaikan kurang
    /**
     * Get the technician that owns the TechnicianCommission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class, 'technician_id', 'id');
    }

    public function orderDetail(): BelongsTo
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id', 'id');
    }
}
