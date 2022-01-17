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
        'ownerid',
        'date',
        'time'
    ];

    public function getReceivedMessages($id = 0){
        if($id === 0){
            return $this ->findAll();
        }

        return array_reverse($this->asArray()
        ->where(['receiverid' => $id, 'ownerid' => $id])
        ->findAll());
    }

    public function getSentMessages($id = 0){
        if($id === 0){
            return $this ->findAll();
        }

        return array_reverse($this->asArray()
        ->where(['senderid' => $id, 'ownerid' => $id])
        ->findAll());
    }

    public function getSpecificReceivedMessages($receiverid, $senderid){
        

        return array_reverse($this->asArray()
        ->where(['receiverid' => $receiverid, 'ownerid' => $receiverid, 'senderid' => $senderid])
        ->findAll());
    }

    public function getSpecificSentMessages($senderid, $receiverid){
        

        return array_reverse($this->asArray()
        ->where(['senderid' => $senderid, 'ownerid' => $senderid, 'receiverid' => $receiverid])
        ->findAll());
        
    }

    public function getSentUserIds($receiverid){
        return $this->distinct()->select('senderid')->where(['receiverid' => $receiverid])->findAll();
    }

    public function getReceivedUserIds($senderid){
        return $this->distinct()->select('receiverid')->where(['senderid' => $senderid])->findAll();
    }
}
