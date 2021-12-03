<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemMediaModel extends Model{
    protected $table = 'itemMedia';

    protected $allowedFields = [
        'mediaID',
        'file',
        'type',
        'itemID'
    ];

    public function getItemMedia($itemid){
        return $this->asArray()
        ->where(['itemID' => $itemid])
        ->findAll();
    }
}