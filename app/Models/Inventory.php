<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'inv_number',
        'dept_code',
        'subdept_code',
        'number_of_items',
        'scan_items',
        'status',
        'receivedby',
        'received_date',
        'countedby',
        'counted_date',
        'notedby',
        'noted_date'
    ];
}
