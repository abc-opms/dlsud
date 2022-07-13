<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FurnitureItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'transfer_furniture_id',
        'qty',
        'unit',
        'item_description',
        'serial_number',
        'fea_number',
        'acq_date',
        'property_number',
        'remarks',
        'evaluatedby',
        'status',
        'eval_by',
        'name'
    ];


    public function main()
    {
        return $this->belongsTo(TransferFurniture::class);
    }
}
