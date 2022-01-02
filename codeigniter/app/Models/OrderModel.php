<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'Orders';

    protected $allowedFields = [
        'orderid',
        'shopperid',
        'sellerid',
        'itemid',
        'active',
        'finished',
        'delivery',
        'waitingDate',
        'ordertime',
        'orderdate'
    ];

    public function getOrder($orderid){
        return $this->asArray()
        ->where(['orderid' => $orderid])->first();
    }

    public function getShopperUserIds($sellerid){
        return $this->distinct()->select('shopperid')->where(['sellerid' => $sellerid])->findAll();
    }

    public function getSellerUserIds($shopperid){
        return $this->distinct()->select('sellerid')->where(['shopperid' => $shopperid])->findAll();
    }

    public function getShopperid($orderid){
        return $this->select('shopperid')->where(['orderid' => $orderid])->first();
    }
    public function getSellerid($orderid){
        return $this->select('sellerid')->where(['orderid' => $orderid])->first();
    }
    public function getActiveSellerOrders($sellerid){
        return $this->asArray()
        ->where(['itemid !=' => null, 'sellerid' => $sellerid, 'active'=>1, 'finished' => 0])
        ->findAll();
    }

    public function getInactiveSellerOrders($sellerid){
        return $this->asArray()
        ->where(['itemid !=' => null, 'sellerid' => $sellerid, 'active'=>0, 'finished' => 0])
        ->findAll();
    }
    public function getActiveShopperOrders($shopperid){
        return $this->asArray()
        ->where(['itemid !=' => null, 'shopperid' => $shopperid, 'active'=>1, 'finished' => 0])
        ->findAll();
    }
    public function getInactiveShopperOrders($shopperid){
        return $this->asArray()
        ->where(['itemid !=' => null, 'shopperid' => $shopperid, 'active'=>0, 'finished' => 0])
        ->findAll();
    }

    public function getShopperItemids($shopperid){
        return $this->distinct()->select('itemid')->where(['itemid !=' => null, 'shopperid' => $shopperid])->findAll();
    }

    public function getSellerItemids($sellerid){
        return $this->distinct()->select('itemid')->where(['itemid !=' => null, 'sellerid' => $sellerid])->findAll();
    }

    public function getFirstInactive($itemid){
        return $this->distinct()->select('orderid')->where(['itemid !=' => null, 'itemid' => $itemid,  'active' => 0, "finished" => 0])->first();
    }
    
    public function getFirstInactiveShopper($itemid){
        return $this->distinct()->select('shopperid')->where(['itemid !=' => null, 'itemid' => $itemid,  'active' => 0, "finished" => 0])->first();
    }

    public function setNextActive($itemid){
        $this
            ->wherein('itemid',[$itemid])
            ->first()
            ->set(['active' => 1])
            ->update();
    }

    public function getTotalOrderCount($sellerid){
        $db = \Config\Database::connect();
        $builder = $db->table('Orders');
        $builder->where('sellerid', $sellerid);
        $builder->selectCount('orderid');
        $query = $builder->get()->getRowArray();
        return $query;
    }

    public function getActiveOrderCount($sellerid){
        $db = \Config\Database::connect();
        $builder = $db->table('Orders');
        $builder->where('sellerid', $sellerid);
        $builder->where('active', 1);
        $builder->selectCount('orderid');
        $query = $builder->get()->getRowArray();
        return $query;
    }

    public function getInactiveOrderCount($sellerid){
        $db = \Config\Database::connect();
        $builder = $db->table('Orders');
        $builder->where('sellerid', $sellerid);
        $builder->where('active', 0);
        $builder->where('finished', 0);
        $builder->selectCount('orderid');
        $query = $builder->get()->getRowArray();
        return $query;
    }

    public function getFinishedOrderCount($sellerid){
        $db = \Config\Database::connect();
        $builder = $db->table('Orders');
        $builder->where('sellerid', $sellerid);
        $builder->where('finished', 1);
        $builder->selectCount('orderid');
        $query = $builder->get()->getRowArray();
        return $query;
    }
}