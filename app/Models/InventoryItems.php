<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItems extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'inventory_id',
        'location',
        'property_number',
        'name',
        'item_description',
        'serial_number',
        'fea_number',
        'acq_date',
        'qty',
        'unit_cost',
        'amount',
        'old_custodian',
        'new_custodian',
        'subdept_code',
        'dept_code',
        'found_date',
        'status',
        'eval_by',
        'item_status',
        'inv_number'

    ];

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('inv_number', $term)
                ->orWhere('name', 'like', $term)
                ->orWhere('item_description', 'like', $term)
                ->orWhere('property_number', 'like', $term)
                ->orWhere('serial_number', 'like', $term)
                ->orWhere('amount', 'like', $term)
                ->orWhere('fea_number', 'like', $term)
                ->orWhere('subdept_code', 'like', $term);
        });
    }
}
