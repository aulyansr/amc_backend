<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetailAttachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='order_detail_attachment';
    public    $timestamps = true;
    protected $guarded = [];

    public function attachment_item(){

        return $this->belongsTo(RepairAttachmentItem::class, 'attachment_id', 'id');
    }

}
