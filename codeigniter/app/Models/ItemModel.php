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
    public function getItemLikeName($name =''){
        $db = \Config\Database::connect();
        $builder = $db->table('items');
        $builder->like('name', $name);
        $query = $builder->get()->getResultArray();
        return $query;
    }
    public function getItemLikeSeller($seller = 0){
        if ($seller === 0) {
            return $this->findAll();
        }
        return $this->asArray()
                ->where(['sellerid' => $seller])
                ->findAll();
    }

    public function getItemMaxPrice($maxprice = 0){
        if($maxprice === 0){
            return $this->findAll();
        }
        $db = \Config\Database::connect();
        $builder = $db->table('items');
        $builder->where('price <=', $maxprice);
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function decrementavailability($itemid){
        $item = $this->where('itemid',$itemid)->first();
        $val = $item['availability'] - 1;
        $this->wherein('itemid',[$itemid])->set(['availability'=>$val])->update();
    }

    public function incrementavailability($itemid){
        $item = $this->where('itemid',$itemid)->first();
        $val = $item['availability'] + 1;
        $this->wherein('itemid',[$itemid])->set(['availability'=>$val])->update();
    }
}
