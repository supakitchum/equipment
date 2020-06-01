<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'user_id',
        'message_id',
        'status',
        'link'
    ];

    static public function messages(){
        return Notification::join('messages','notifications.message_id','=','messages.id')
            ->where('user_id',auth()->user()->id)
            ->limit(10)
            ->get();
    }
}
