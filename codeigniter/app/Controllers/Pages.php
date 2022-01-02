<?php

namespace App\Controllers;

use App\Models\databasetest;
use App\Models\ItemMediaModel;
use App\Models\ItemModel;
use App\Models\ReviewModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;

class Pages extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('this page does not exist');
    }

    public function aboutredirect()
    {
        return $this->setPage('about');
    }
    public function homeredirect()
    {
        $model = new ItemModel();

        $data = [
            'items'  => $model->getItems(),
            'title' => 'Items archive',
        ];

        echo view('templates/header', $data);
        echo view('Items/itemoverview', $data);
        echo view('templates/footer', $data);
    }

    public function itemredirect($itemid = 0)
    {
        $itemmodel = new ItemModel();

        $data['item'] = $itemmodel->getItems($itemid);

        if (empty($data['item'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the item: ' . $itemid);
        }

        $reviewmodel = new ReviewModel();

        $data['reviews'] = $reviewmodel->getItemReviews($itemid);
        $Usersmodel = new UsersModel();
        
        $reviewids = $reviewmodel->getUserIds($itemid);

        $array[] = [];

        foreach($reviewids as $rid){
            array_push($array, $Usersmodel->getUserandID($rid));
        }
        array_shift($array);
        $data['reviewers'] = $array;

        $data['average'] = $reviewmodel->getAverageReviewScore($itemid);

        $itemmediamodel = new ItemMediaModel();

        $data['media'] = $itemmediamodel->getItemMedia($itemid);

        $data['nameid'] = $Usersmodel->getUserByID($data['item']['sellerid']);
        echo view('templates/header', $data);
        echo view('Items/item', $data);
        echo view('templates/footer', $data);
    }

}
