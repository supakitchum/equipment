<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskCalLog extends Model
{
    protected $fillable = [
        'task_id',
        'assign_date',
        'complete_date'
    ];
}
