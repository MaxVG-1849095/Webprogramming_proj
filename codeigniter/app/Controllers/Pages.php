<?php

namespace App\Controllers;

use App\Models\databasetest;
use App\Models\ItemModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;

class Pages extends BaseController
{
    public function index()
    {
        return view("pages/home");
    }

    public function aboutredirect(){
        return $this->setPage('about');
    }
    public function homeredirect(){
        $model = new ItemModel();

        $data = [
            'items'  => $model->getItems(),
            'title' => 'Items archive',
        ];

        echo view('templates/header', $data);
        echo view('pages/home', $data);
        echo view('Items/itemoverview', $data);
        echo view('templates/footer', $data);
    }

    public function itemredirect($itemid = 0){
        $model = new ItemModel();

        $data['item'] = $model->getItems($itemid);

        if (empty($data['item']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: '. $itemid);
        }

        echo view('templates/header', $data);
        echo view('pages/home', $data);
        echo view('Items/item', $data);
        echo view('templates/footer', $data);
    }

    public function accountindex()
    {
    $model = new UsersModel();

    $data = [
        'users'  => $model->getUsers(),
        'title' => 'Users archive',
    ];

    echo view('templates/header', $data);
    echo view('pages/accountoverview', $data);
    echo view('templates/footer', $data);
}
    public function accountredirect($userid = 0){
        $model = new UsersModel();

        $data['users'] = $model->getUsers($userid);

        if (empty($data['users']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: '. $userid);
        }

        echo view('templates/header', $data);
        echo view('pages/account', $data);
        echo view('templates/footer', $data);
    }

}