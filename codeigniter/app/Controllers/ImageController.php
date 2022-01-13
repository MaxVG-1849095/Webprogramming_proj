<?php

namespace App\Controllers;

use App\Models\ItemMediaModel;
use App\Models\UserMediaModel;

class ImageController extends BaseController
{
    function __construct()
    {
        //parent::__construct();
    }

    public function storeItemImage()
    {
        $session = session();
        $mediamodel = new ItemMediaModel();
        if ( empty($this->request->getPost('itemid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $input = $this->validate([
            'media_file' => 
            'uploaded[media_file]',
            'mime_in[media_file,image/jpg,image/jpeg,image/gif,image/png,video/mp4]',
            'max_size[media_file,4096]',
        ]);
        //log_message('error', $this->request->getFile('media_file')->getRandomName());
        //log_message('error', $this->request->getFile('media_file')->getClientMimeType());
        if (!$input) {
            $session->setFlashdata('picturefeedback','please choose a valid file');
        } else {
            $file = $this->request->getFile('media_file');
            
            $file->move(ROOTPATH .'public/Images/Items');
            
            

            $mediamodel->insert([
                'file' =>  $file->getName(),
                'type'  => $file->getClientMimeType(),
                'itemID' => $this->request->getPost('itemid'),
            ]);
            $session->setFlashdata('picturefeedback', 'file uploaded');
        }
        
        $redirectString = "/wareeditor/". $this->request->getPost('itemid');
        //print_r($redirectString);
        return redirect()->to($redirectString);
    }

    public function storeProfileImage()
    {
        $session = session();
        $mediamodel = new UserMediaModel();
        if ( empty($this->request->getPost('userid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $input = $this->validate([
            'media_file' => 
            'uploaded[media_file]',
            'mime_in[media_file,image/jpg,image/jpeg,image/gif,image/png,video/mp4]',
            'max_size[media_file,4096]',
        ]);
        //log_message('error', $this->request->getFile('media_file')->getRandomName());
        //log_message('error', $this->request->getFile('media_file')->getClientMimeType());
        if (!$input) {$session->setFlashdata('picturefeedback','please choose a valid file');print_r('Choose a valid file');
        } else {
            $file = $this->request->getFile('media_file');
            $file->move(ROOTPATH .'public/Images/Users');

            $mediamodel->insert([
                'file' =>  $file->getName(),
                'type'  => $file->getClientMimeType(),
                'userID' => $this->request->getPost('userid'),
            ]);
            
            $session->setFlashdata('picturefeedback', 'file uploaded');
        }
        return redirect()->to('/profileedit');
    }
}
