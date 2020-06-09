<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskCalEquipment extends Model
{
    protected $table = 'task_cal_equipments';
    protected $fillable = [
        'task_name',
        'equipment_id',
        'user_id',
        'due_date',
        'description',
        'state'
    ];
}
