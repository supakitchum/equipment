<?php

use App\Notification;

if (!function_exists('isActive')) {
    function isActive($name){
        if (\Request::is($name))
            return 'active';
        else
            return '';
    }
}
if (!function_exists('checkRole')) {
    function checkRole($role){
        if (auth()->user()->role == $role)
            return true;
        else
            return false;
    }
}

if (!function_exists('equipmentState')) {
    function equipmentState($state){
        switch ($state){
            case '0':
                return '<span class="badge badge-success">พร้อมใช้งาน</span>';
                break;
            case '1':
                return '<span class="badge badge-warning">ถูกใช้งานอยู่</span>';
                break;
            case '2':
                return '<span class="badge badge-danger">กำลังซ่อมบำรุง</span>';
                break;
            case '3':
                return '<span class="badge badge-danger">ไม่มีอุปกรณ์นี้แล้ว</span>';
                break;
        }
    }
}

if (!function_exists('random_string')) {
    function random_string($length = 10) {
        while (true){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }
}

if (!function_exists('reservingState')) {
    function reservingState($state){
        switch ($state){
            case 0:
                return '<span class="badge badge-info text-uppercase">Requesting</span>';
                break;
            case 1:
                return '<span class="badge badge-success text-uppercase">Approved</span>';
                break;
            case 2:
                return '<span class="badge badge-danger text-uppercase">Rejected</span>';
                break;
            case 3:
                return '<span class="badge badge-warning text-uppercase">Transferred</span>';
                break;
            case 4:
                return '<span class="badge badge-warning text-uppercase">Transferring</span>';
                break;
            case 5:
                return '<span class="badge badge-success text-uppercase">Return</span>';
                break;
        }
    }
}

if (!function_exists('taskState')) {
    function taskState($state){
        switch ($state){
            case 0:
                return '<span class="badge badge-info text-uppercase">Pending</span>';
                break;
            case 1:
                return '<span class="badge badge-success text-uppercase">Complete</span>';
                break;
        }
    }
}

if (!function_exists('sendRequestNotification')) {
    function sendRequestNotification($user_id,$link){
        Notification::create([
            'type' => 'REQUEST',
            'user_id' => $user_id,
            'message_id' => 1,
            'status' => 0,
            'link' => $link
        ]);
    }
}

if (!function_exists('sendAlertNotification')) {
    function sendAlertNotification($user_id,$link){
        Notification::create([
            'type' => 'ALERT',
            'user_id' => $user_id,
            'message_id' => 2,
            'status' => 0,
            'link' => $link
        ]);
    }
}

if (!function_exists('sendTransferNotification')) {
    function sendTransferNotification($user_id,$link){
        Notification::create([
            'type' => 'TRANSFER',
            'user_id' => $user_id,
            'message_id' => 3,
            'status' => 0,
            'link' => $link
        ]);
    }
}

if (!function_exists('sendApproveNotification')) {
    function sendApproveNotification($user_id,$link){
        Notification::create([
            'type' => 'APPROVE',
            'user_id' => $user_id,
            'message_id' => 4,
            'status' => 0,
            'link' => $link
        ]);
    }
}

if (!function_exists('sendRejectNotification')) {
    function sendRejectNotification($user_id,$link){
        Notification::create([
            'type' => 'REJECT',
            'user_id' => $user_id,
            'message_id' => 5,
            'status' => 0,
            'link' => $link
        ]);
    }
}

if (!function_exists('sendRestoreNotification')) {
    function sendRestoreNotification($user_id,$link){
        Notification::create([
            'type' => 'RETURN_CAL',
            'user_id' => $user_id,
            'message_id' => 6,
            'status' => 0,
            'link' => $link
        ]);
    }
}
