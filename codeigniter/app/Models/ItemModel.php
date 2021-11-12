<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model 
{
    protected $table = 'items';

    public function getItems($id = 0)
    {
        if($id === 0){
            return $this->findAll();
        }

        return $this->asArray()
                ->where(['itemid' => $id])
                ->first();
}
}