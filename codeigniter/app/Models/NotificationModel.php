<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'Notifications';

    protected $allowedFields = [
        'userid',
        'content',
        'notid',
        'attachment',
        'itemid'
    ];

    public function getUserNotis($userid){
        return $this->asArray()
        ->where(['userid' =>$userid])
        ->findAll();
    }
}