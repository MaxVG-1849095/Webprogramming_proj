<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages';

    protected $allowedFields = [
        'messageid',
        'senderid',
        'receiverid',
        'content',
        'systemmesage'
    ];

    public function getReceivedMessages($id = 0){
        if($id === 0){
            return $this ->findAll();
        }

        return $this->asArray()
        ->where(['receiverid' => $id])
        ->findAll();
    }

    public function getUserIds($receiverid){
        return $this->distinct()->select('senderid')->where(['receiverid' => $receiverid])->findAll();
    }
}
