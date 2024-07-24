<?php

namespace App\Models;

use App\Traits\SelfReferenceTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory, SoftDeletes, SelfReferenceTrait;

    protected $fillable = ['price_warranty', /* other fillable attributes */];

    // Define mutator for price_warranty attribute
    public function setPriceWarrantyAttribute($value)
    {
        // If $value is null or empty, set price_warranty to 0
        $this->attributes['price_warranty'] = empty($value) ? 0 : $value;
    }

    protected $guarded = ['id'];
    public function __construct()
    {
        parent::__construct();
        $this->parentColumn = 'child_service_id';
    }
    public function getCompletedWarrantyAttribute()
    {
        $data = convertDaysToMonthsWeeksDays($this->attributes['warranty']);
        $text = '';
        if ($data['months'] > 0) {
            $text = $data['months'] . ' bulan';
        }
        if ($data['weeks'] > 0) {
            $text = $text . ' ' . $data['weeks'] . ' minggu';
        }
        if ($data['days'] > 0) {
            $text = $text . ' ' . $data['days'] . ' hari';
        }
        if ($text == '') {
            $text = 'Tidak ada garansi';
        }
        return $text;
    }
    public function customer()
    {
        $this->belongsTo(MasterCustomer::class, 'master_customer_id', 'id');
    }

    public function service_type()
    {
        return $this->belongsTo(ServicesType::class, 'services_type_id', 'id');
    }
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(RepairAttachmentItem::class, 'service_activities', 'service_id', 'repair_attachment_item_id')->withTimestamps();
    }

    public function child_services(): BelongsToMany
    {
        return $this->belongsToMany(ChildService::class, 'service_children', 'service_id', 'child_service_id')->withTimestamps();
    }

    public function spare_part(): BelongsToMany
    {
        return $this->belongsToMany(SparePart::class, 'service_spare_part', 'service_id', 'spare_part_id')->withPivot('price', 'price_warranty')->withTimestamps();
    }
}
