<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'child_services';
    protected $primaryKey = 'id';
    public    $timestamps = true;
    protected $guarded =[];


    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_children', 'service_id', 'child_service_id');
    }

    public function service_type(){
        return $this->belongsTo(ServicesType::class, 'services_type_id', 'id');
    }
}
