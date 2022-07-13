<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qrtagging extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'rqr_number',
        'property_number',
        'reason',
        'reqby',
        'req_date',
        'generated_date',
        'generatedby',
        'subdept_code',
        'status'
    ];

    public function item()
    {
        return $this->hasMany(QrItems::class);
    }
}
