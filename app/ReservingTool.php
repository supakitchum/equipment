<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservingTool extends Model
{
    protected $fillable = [
        'user_id',
        'equipment_id',
        'approved_by',
        'reserving_state',
        'description',
        'restore_state'
    ];
}
