<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftInventory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'dept_unit',
        'position',
        'date',
        'ta_num',
        'reason',
        'sched_one',
        'sched_two',
        'draft_num',
        'user_id',
    ];
}
