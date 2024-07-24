<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technician_level extends Model
{
    use HasFactory, SoftDeletes;

	public function technicians()
	{
		return $this->hasMany('App\Models\Technician');
	}
}
