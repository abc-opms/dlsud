<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDisposal extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [

        'rdf_number',
        'from',
        'date',
        'subdept_code',
        'reason',

        'endorsedto',
        'endorsed_date',

        'checkedby',
        'checked_date',

        'approvedby',
        'approved_date',

        'evaluatedby',
        'evaluated_date',

        'notedby',
        'noted_date',

        'postedby',
        'posted_date',

        'status',
        'read_at',
        'id',
        'eval_by'
    ];


    public function item()
    {
        return $this->hasMany(DisposalItem::class);
    }
}
