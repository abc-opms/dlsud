<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'supplier_code',
        'name',
        'address',
        'telnum',
        'telnum_al',
        'faxnum',
        'faxnum_al',
        'category',
    ];
}
