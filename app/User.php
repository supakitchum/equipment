<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function sendAllAdminNotification($type,$message_id,$link){
        //  ส่งแจ้งเตือนไปให้แอดมินทุกคน
        $admins = User::where('role', '=', 'admin')->get();

        // Create Message
        foreach ($admins as $admin) {
            Notification::create([
                'type' => $type,
                'user_id' => $admin->id,
                'message_id' => $message_id,
                'status' => 0,
                'link' => $link
            ]);
        }
    }
}
