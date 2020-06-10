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
        'description',
        'equipment_state'
    ];
}
