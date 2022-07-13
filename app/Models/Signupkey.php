<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signupkey extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'school_id',
        'role',
        'dept_code',
        'subdept_code',
        'skey',
        'email',
        'status',
    ];
}
