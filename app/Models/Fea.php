<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fea extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [

        'fea_number',
        'rr_number',

        'checkedby',
        'checked_date',

        'notedby',
        'noted_date',

        'recordedby',
        'recorded_date',

        'receivedby',
        'received_date',

        'rnotedby',
        'rnoted_date',

        'status',

        'subdept_code',
        'dept_code',

        'acq_date',
        'read_at',

    ];
}
