<?php

namespace App\Controllers;

use App\Models\MessageModel;
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
        $array[] = [];

        $senderids = $messagemodel->getUserIds($_SESSION['id']);

        foreach($senderids as $sid){
            array_push($array, $usersmodel->getUserandID($sid));
        }
        array_shift($array);
        $data = [
            'senders' => $array,
            'messages' => $messagemodel->getReceivedMessages($_SESSION['id']),
            'highestid' => $usersmodel->getMaxID(),
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
}
