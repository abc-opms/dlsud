<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferFurniture extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [

        'rtf_number',
        'from',
        'date',
        'subdept_code',
        'reason',
        'receiving_dept',
        'custodian',
        'dept_head',

        'checkedby',
        'checked_date',

        'approvedby',
        'approved_date',

        'postedby',
        'posted_date',

        'status',
        'read_at'

    ];


    public function item()
    {
        return $this->hasMany(FurnitureItem::class);
    }
}
