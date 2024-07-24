<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairAttachmentDetail extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $table = 'repair_attachment_details';
    protected $guarded = [];
    protected $primaryKey = 'id';
}
