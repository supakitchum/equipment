<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $fillable = [
        'code',
        'serial',
        'name',
        'category',
        'type',
        'maintenance_date',
        'maintenance_type',
        'description',
        'equipment_state'
    ];
}
