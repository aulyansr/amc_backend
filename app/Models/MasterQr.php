<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterQr extends Model
{
    use HasFactory, SoftDeletes;
    protected $table      = 'master_qr';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];

    /**
     * Get the masterCustomer that owns the MasterQr
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function masterCustomer(): BelongsTo
    {
        return $this->belongsTo(MasterCustomer::class,'master_customer_id','id');
    }

    /**
     * Get the masterAc that owns the MasterQr
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ac_customer(): BelongsTo
    {
        return $this->belongsTo(AcCustomer::class,'master_ac_customer_id','id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'master_teknisi_id','id');
    }



    public function getRouteKeyName(){
        return 'url_unique';
    }
}
