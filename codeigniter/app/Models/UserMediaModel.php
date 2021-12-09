<?php

namespace App\Models;

use CodeIgniter\Model;

class UserMediaModel extends Model{
    protected $table = 'userMedia';

    protected $allowedFields = [
        'mediaID',
        'file',
        'type',
        'userID'
    ];

    public function getUserMedia($userid){
        return $this->asArray()
        ->where(['userID' => $userid])
        ->findAll();
    }
}