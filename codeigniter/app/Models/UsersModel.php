<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model 
{
    protected $table = 'Users';

    protected $allowedFields = [
        'name',
        'description',
        'PASSWORD',
        'id',
        'email',
        'slug'
    ];
    public function getUserLogin($email, $pw){
        if($email === 0 OR $pw === 0){
            return 0;
        }
        return $this->asArray()
                ->where(['email' => $email], ['PASSWORD' => $pw])
                ->first();
    }
    public function getUsers($id = 0)
    {
        if($id === 0){
            return $this->findAll();
        }

        return $this->asArray()
                ->where(['id' => $id])
                ->first();
    }

    public function getUserByID($id = 0){
        return $this->select('name')->where(['id' => $id])->first();
    }
    public function getUserandID($id = 0){
        return $this->select('id,name')->where(['id' => $id])->first();
    }
    public function getUsersandID(){
        
        return $this->select('id,name')->findAll();
        
    }
    public function getMaxID(){
        $db = \Config\Database::connect();
        $builder = $db->table('Users');
        $builder->selectMax('id');
        $query = $builder->get()->getRowArray();
        return $query;
    }
}