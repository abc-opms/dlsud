<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custodian extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'first_name',
        'last_name',
        'department_id',
        'school_id',
        'position',
        'previous_position',
        'status'
    ];
}
