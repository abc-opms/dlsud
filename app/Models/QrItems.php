<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrItems extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'rqr_number',
        'qrtagging_id',
        'property_number',
        'reason',
        'status',
        'serial_number',
        'oum',
        'item_status',
        'fea_number',
        'acq_date',
        'item',
    ];

    public function main()
    {
        return $this->belongsTo(qrtagging::class);
    }
}
