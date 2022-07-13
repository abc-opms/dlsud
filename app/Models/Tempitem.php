<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempitem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'dept_id',
        'acc_code',
        'oum',
        'unit_cost',
        'order_qty',
        'deliver_qty',
        'amount',
        'rr_number',
        'receivedby',
        'item',
        'school_id',
        'id',
        'addItemRR',
    ];
}
