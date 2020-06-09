<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservingLog extends Model
{
    protected $fillable = [
        'reserving_id',
        'approve_date',
        'transfer_date',
        'reject_date',
        'request_date',
        'return_date',
        'return_reason'
    ];
}
