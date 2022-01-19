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
    //loads correct view that the user has searched for
    public function index()
    {
        $session = session();
        if ( empty($this->request->getPost('searchtype'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        //$this->dosearch($this->request->getPost('searchtype'), $this->request->getPost('search'));
        if(empty($this->request->getPost('search'))){
            return redirect()->to('/search/'.$this->request->getPost('searchtype'));
        }
        else{
            return redirect()->to('/search/'.$this->request->getPost('searchtype').'/'.$this->request->getPost('search'));
        }
        
    }

    public function dosearch($type, $val){
        if ($type === "Search user") {
            $usermodel = new UsersModel();
            $data['foundusers'] = $usermodel->getUsersbyname($val);

            echo view('templates/header', $data);
            echo view('pages/profileOverview', $data);
            echo view('templates/footer', $data);
        } elseif ($type === "Search by itemname") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemLikeName($val);
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
        elseif ($type === "Search max price") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemMaxPrice($val);
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
        elseif ($type === "Search by sellerid") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemLikeSeller($val);
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
    }
    public function dosearchnull($type){
        if ($type === "Search user") {
            $usermodel = new UsersModel();
            $data['foundusers'] = $usermodel->getUsersbyname();

            echo view('templates/header', $data);
            echo view('pages/profileOverview', $data);
            echo view('templates/footer', $data);
        } elseif ($type === "Search by itemname") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemLikeName();
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
        elseif ($type === "Search max price") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemMaxPrice();
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
        elseif ($type === "Search by sellerid") {
            $itemmodel = new ItemModel();
            $data['items'] = $itemmodel->getItemLikeSeller();
            echo view('templates/header', $data);
            echo view('Items/itemoverview', $data);
            echo view('templates/footer', $data);
        }
    }
    
}
