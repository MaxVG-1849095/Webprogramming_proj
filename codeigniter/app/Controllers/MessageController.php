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
        if ( !$session->has('id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to load this page');
        }
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

    public function loadSpecificMessages(){
        $session = session();
        
        if($this->request->getPost('userid') ==0){
            log_message('error','in if');
            return redirect()->to('/messages');
        }
        else{
            $redirectString = '/messages/'.$this->request->getPost('userid');
            log_message('error','in else');
            print_r($redirectString);
            return redirect()->to($redirectString);
        }

    }

    public function loadSpecificMessagesHelper($userid){
        $messagemodel = new MessageModel();
        $usersmodel = new UsersModel();
        $notimodel = new NotificationModel();
        $session=session();
        $senderarray[] = [];
        $receiverarray[]=[];
        if ( !$session->has('id')|empty($userid)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to load this page');
        }
        array_push($senderarray, $usersmodel->getUserandID($userid));
        array_shift($senderarray);

        array_push($receiverarray, $usersmodel->getUserandID($userid));
        array_shift($receiverarray);

        $data = [
            'senders' => $senderarray,
            'receivers' => $receiverarray,
            'received_messages' => $messagemodel->getSpecificReceivedMessages($_SESSION['id'], $userid),
            'sent_messages' => $messagemodel->getSpecificSentMessages($_SESSION['id'], $userid),
            'highestid' => $usersmodel->getMaxID(),
            'notifications' => $notimodel->getUserNotis($_SESSION['id'],)
        ];
        $this->template('Profile/messages', $data);
    }

    public function sendMessage()
    {
        $session = session();
        $messagemodel = new MessageModel();
        $usermodel = new UsersModel();
        if ( !$session->has('id')|empty($this->request->getPost('receiverid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        if ($this->request->getMethod() === 'post' && $this->validate([
            'receiverid' => 'required',
            'content'  => 'required',
        ]) && $this->request->getPost('senderid') != $this->request->getPost('receiverid') && $usermodel->getUserByID($this->request->getPost('receiverid'))!= null) {
            $messagemodel->insert([
                'senderid' => $this->request->getPost('senderid'),
                'receiverid' => $this->request->getPost('receiverid'),
                'content' => $this->request->getPost('content'),
                'systemmessage' => 0,
                'ownerid' => $this->request->getPost('senderid'),
            ]);
            $messagemodel->insert([
                'senderid' => $this->request->getPost('senderid'),
                'receiverid' => $this->request->getPost('receiverid'),
                'content' => $this->request->getPost('content'),
                'systemmessage' => 0,
                'ownerid' => $this->request->getPost('receiverid'),
            ]);
        }else
        {
            $session->setFlashdata('messageerror', 'Something went wrong, check if you entered everything correctly (Unable to send message to yourself or accounts that do not exist!)');
        }
        return redirect()->to('/messages');
    }

    public function removeMessage(){
        $session = session();
        $messagemodel = new MessageModel();
        if ( !$session->has('id')|empty($this->request->getPost('messageid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $message_id = $this->request->getPost('messageid');

        $messagemodel
            ->wherein('messageid',[$message_id])
            ->wherein('ownerid', [$_SESSION['id']])
            ->delete();
        
            return redirect()->to('/messages');
    }

    public function removeNotification(){
        $session=session();
        $notimodel = new NotificationModel();
        if ( !$session->has('id')|empty($this->request->getPost('notiId'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $noti_id = $this->request->getPost('notiId');

        $notimodel
        ->wherein('notid', [$noti_id])
        ->delete();
        
        return redirect()->to('/messages');
    }

    public function reviewpage(){
        $session = session();
        $itemmodel = new ItemModel();
        if ( !$session->has('id')|empty($this->request->getPost('notid'))|empty($this->request->getPost('itemid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to load this page');
        }
        $data =[
            'item' => $itemmodel->getItems($this->request->getPost('itemid')),
            'notid' => $this->request->getPost('notid'),
        ];

        $this->template('Items/itemreviewform',$data);
    }

    public function createReview(){
        $session = session();
        $reviewmodel = new ReviewModel();
        if ( !$session->has('id')|empty($this->request->getPost('itemid'))|empty($this->request->getPost('description'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
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

        return redirect()->to('/messages');
    }
}
