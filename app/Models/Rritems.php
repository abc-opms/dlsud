<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rritems extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'acc_code',
        'item_description',
        'oum',
        'unit_cost',
        'order_qty',
        'deliver_qty',
        'amount',
        'rr_number',
        'receivedby',
        'name',
        'acq_date',
        'receivingreport_id',

    ];

    public function receivingreport()
    {
        //return $this->belongsTo('App\Models\Receivingreports');
    }


    public function code()
    {
        return $this->hasMany(SerialPropertyCode::class);
    }
}
