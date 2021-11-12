<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model 
{
    protected $table = 'Users';

    public function getUsers($id = 0)
    {
        if($id === 0){
            return $this->findAll();
        }

        return $this->asArray()
                ->where(['id' => $id])
                ->first();
}
}