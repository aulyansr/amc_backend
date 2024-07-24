<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairAttachmentItem extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $table = 'repair_attachment_items';
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function attachments()
    {
        return $this->belongsToMany(RepairAttachment::class, 'repair_attachment_details');
    }
}
