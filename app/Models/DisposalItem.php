<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposalItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'item_disposal_id',
        'qty',
        'unit',
        'item_description',
        'serial_number',
        'fea_number',
        'acq_date',
        'property_number',
        'remarks',
        'action',
        'status',
        'name',
        'acc_code'
    ];


    public function main()
    {
        return $this->belongsTo(ItemDisposal::class);
    }
}
