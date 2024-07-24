<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RepairAttachment extends Model
{
    use HasFactory;
    // SoftDeletes;

    protected $table = 'repair_attachments';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(RepairAttachmentItem::class, 'repair_attachment_details', 'repair_attachment_id', 'repair_attachment_item_id')->withTimestamps();
    }
}
