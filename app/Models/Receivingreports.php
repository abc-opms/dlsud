<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivingreports extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'supplier_code',
        'rr_number',
        'delivery_date',
        'ponum',
        'invoice',
        'invoice_date',
        'receipt_photo_path',
        'dept_code',

        'checked_date',
        'checkedby',

        'preparedby',
        'prepared_date',

        'receivedby',
        'received_date',

        'total',
        'fea_number',
        'receivedby',
        'read_at',
        'status'
    ];



    public function rritems()
    {
        return $this->hasMany('Spp\Models\Rritems');
    }
}
