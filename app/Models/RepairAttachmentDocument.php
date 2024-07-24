<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RepairAttachmentDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'repair_attachment_documents';
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(RepairAttachmentDocumentDetail::class, 'repair_attachment_document_id', 'id');
    }
}
