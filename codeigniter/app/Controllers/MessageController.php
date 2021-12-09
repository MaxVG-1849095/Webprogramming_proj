<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\MessageModel;
use App\Models\NotificationModel;
use App\Models\ReviewModel;
use App\Models\UsersModel;

class MessageController extends BaseController
{
    function __construct()
    {
        //parent::__construct();
    }

    public function loadMessages()
    {
        $session = session();
        $messagemodel = new MessageModel();
        $usersmodel = new UsersModel();
        $notimodel = new NotificationModel();
        $senderarray[] = [];
        $receiverarray[]=[];

        $senderids = $messagemodel->getSentUserIds($_SESSION['id']);

        foreach($senderids as $sid){
            array_push($senderarray, $usersmodel->getUserandID($sid));
        }
        array_shift($senderarray);

        $receiverids = $messagemodel->getReceivedUserIds($_SESSION['id']);

        foreach($receiverids as $rid){
            array_push($receiverarray, $usersmodel->getUserandID($rid));
        }
        array_shift($receiverarray);
        
        $data = [
            'senders' => $senderarray,
            'receivers' => $receiverarray,
            'received_messages' => $messagemodel->getReceivedMessages($_SESSION['id']),
            'sent_messages' => $messagemodel->getSentMessages($_SESSION['id']),
            'highestid' => $usersmodel->getMaxID(),
            'notifications' =>$notimodel->getUserNotis($_SESSION['id']),
        ];

        $this->template('Profile/messages', $data);
    }

    public function sendMessage()
    {
        $session = session();
        $messagemodel = new MessageModel();

        if ($this->request->getMethod() === 'post' && $this->validate([
            'receiverid' => 'required',
            'content'  => 'required',
        ])) {
            $messagemodel->insert([
                'senderid' => $this->request->getPost('senderid'),
                'receiverid' => $this->request->getPost('receiverid'),
                'content' => $this->request->getPost('content'),
                'systemmessage' => 0,
            ]);
        }
        $this->loadMessages();
    }

    public function removeMessage(){
        $session = session();
        $messagemodel = new MessageModel();
        $message_id = $this->request->getPost('messageid');

        $messagemodel
            ->wherein('messageid',[$message_id])
            ->delete();
        
        $this->loadMessages();
    }

    public function removeNotification(){
        $session=session();
        $notimodel = new NotificationModel();
        $noti_id = $this->request->getPost('notiId');

        $notimodel
        ->wherein('notid', [$noti_id])
        ->delete();
        
        $this->loadMessages();
    }

    public function reviewpage(){
        $session = session();
        $itemmodel = new ItemModel();
        $data =[
            'item' => $itemmodel->getItems($this->request->getPost('itemid')),
            'notid' => $this->request->getPost('notid'),
        ];

        $this->template('Items/itemreviewform',$data);
    }

    public function createReview(){
        $session = session();
        $reviewmodel = new ReviewModel();

        if ($this->request->getMethod() === 'post'&& $this->validate([
            'rating' => 'required',
            'description' => 'required',
        ])){
            $reviewmodel->insert([
                'itemID' => $this->request->getPost('itemid'),
                'userID' => $_SESSION['id'],
                'reviewtext' => $this->request->getPost('description'),
                'score' => $this->request->getPost('rating'),
            ]);
        }

        $notimodel = new NotificationModel();

        $notimodel
        ->wherein('notid', [$this->request->getPost('notid')])
        ->delete();
        $itemmodel = new ItemModel();
        $notimodel->insert([
            'userid' => $_SESSION['id'],
            'content' => "Thanks for leaving the review on: " . $itemmodel->getItems($this->request->getPost('itemid'))['name'] ."!",
            
        ]);

        $this->loadMessages();
    }
}
