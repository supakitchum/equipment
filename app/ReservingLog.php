<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservingLog extends Model
{
    protected $fillable = [
        'reserving_id',
        'return_reason',
        'request_date',
        'approve_date',
        'transfer_date',
        'reject_date'
    ];

    protected $dates = [
        'approve_date',
        'transfer_date',
        'reject_date',
        'request_date',
        'return_date'
    ];
}
