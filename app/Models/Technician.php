<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use BenSampo\Enum\Enum;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class Technician extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $hidden = [
        'password', 'remember_token',
    ];

	public function technician_level()
	{
		return $this->belongsTo('App\Models\Technician_level');
	}

    /**
     * The technician that belong to the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_technician', 'technician_id' ,'team_id')->withPivot(['status'])->withTimestamps();
    }
    public function technician_commission(){
        return $this->hasMany(TechnicianCommission::class);
    }
}
