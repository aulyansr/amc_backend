<?php

namespace App\Traits;

trait SelfReferenceTrait
{
    protected $parentColumn;

    public function __construct($parentColumn = 'partner_id')
    {
        $this->parentColumn = $parentColumn;
    }

    public function parent()
    {
        return $this->belongsTo(static::class);
    }

    public function children()
    {
        return $this->hasMany(static::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function root()
    {
        return $this->parent
            ? $this->parent->root()
            : $this;
    }
}
