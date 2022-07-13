<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialPropertyCode extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'rritems_id',
        'item_description',
        'name',
        'amount',
        'serial_number',
        'property_code',
        'rr_number',
        'fea_number',
        'acq_date',
        'dept_code',
        'subdept_code',
        'old_custodian',
        'new_custodian',
        'inv_number',
        'inv_status',
        'item_status',
        'status',
        'oum'


    ];


    public function item()
    {
        return $this->belongsTo(Rritems::class);
    }
}
