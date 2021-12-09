<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model 
{
    protected $table = 'Reviews';

    protected $allowedFields = [
        'reviewID',
        'itemID',
        'userID',
        'reviewtext',
        'score'
    ];
    
    public function getItemReviews($id = 0)
    {
        
        return $this->asArray()
                ->where(['itemID' => $id])
                ->findAll();
        }
    public function getUserIds($itemid){
        return $this->distinct()->select('userID')->where(['itemID' => $itemid])->findAll();
    }
    public function getAverageReviewScore($itemid){
        $db = \Config\Database::connect();
        $builder = $db->table('Reviews');
        $builder->where('itemID', $itemid);
        $builder->selectAvg('score');
        $query = $builder->get()->getRowArray();
        return $query;
    }
}