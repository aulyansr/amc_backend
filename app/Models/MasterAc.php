<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterAc extends Model
{
    use HasFactory, SoftDeletes;
    protected $table      = 'master_ac';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];

    /**
     * Get all of the masterQr for the MasterAc
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function masterQr(): HasMany
    {
        return $this->hasMany(MasterQr::class,'ac_id','id');
    }
    public function masterCustomer(): BelongsTo
    {
        return $this->belongsTo(MasterCustomer::class,'master_customer_id','id');
    }

    public function getAcFullNameAttribute(){
        return "$this->brand - $this->ac_name ( $this->model ) ";
    }

}
