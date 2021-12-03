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
}