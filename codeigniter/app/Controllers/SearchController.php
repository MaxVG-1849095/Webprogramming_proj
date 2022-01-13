<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\UsersModel;

class SearchController extends BaseController
{
    function __construct()
    {
        //parent::__construct();
    }

    public function index()
    {
        $session = session();
        if ( empty($this->request->getPost('searchtype'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        if ($this->request->getPost('searchtype') === "Search user") {
            $usermodel = new UsersModel();
            $data['foundusers'] = $usermodel->getUsersbyname($this->request->getPost('search'));

            echo view('templates/header', $data);
            echo view('pages/profileOverview', $data);
            echo view('templates/footer', $data);
        } elseif ($this->request->getPost('searchtype') === "Search by itemname") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemLikeName($this->request->getPost('search'));
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
        elseif ($this->request->getPost('searchtype') === "Search max price") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemMaxPrice($this->request->getPost('search'));
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
        elseif ($this->request->getPost('searchtype') === "Search by sellerid") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemLikeSeller($this->request->getPost('search'));
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
    }
}
