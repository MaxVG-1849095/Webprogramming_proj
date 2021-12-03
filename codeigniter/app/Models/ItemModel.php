<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'items';

    protected $allowedFields = [
        'itemid',
        'name',
        'description',
        'sellerid',
        'slug',
        'price',
        'availability',
        'filename'
    ];

    public function getItems($id = 0)
    {
        if ($id === 0) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['itemid' => $id])
            ->first();
    }
    public function getItemsSellerid($id = 0){
        return $this->asArray()
                ->where(['sellerid' => $id])
                ->findAll();
    }
    
}
