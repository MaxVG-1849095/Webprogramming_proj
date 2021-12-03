<?php

namespace App\Controllers;

use App\Models\ItemMediaModel;

class ImageController extends BaseController
{
    function __construct()
    {
        //parent::__construct();
    }

    public function storeItemImage()
    {
        $mediamodel = new ItemMediaModel();

        $input = $this->validate([
            'media_file' => 
            'uploaded[media_file]',
            'mime_in[media_file,image/jpg,image/jpeg,image/gif,image/png,video/mp4]',
            'max_size[media_file,4096]',
        ]);
        //log_message('error', $this->request->getFile('media_file')->getRandomName());
        //log_message('error', $this->request->getFile('media_file')->getClientMimeType());
        if (!$input) {
            print_r('Choose a valid file');
        } else {
            $file = $this->request->getFile('media_file');
            $file->move(ROOTPATH .'public/Images/Items');

            $mediamodel->insert([
                'file' =>  $file->getName(),
                'type'  => $file->getClientMimeType(),
                'itemID' => $this->request->getPost('itemid'),
            ]);
            
            print_r('File has successfully uploaded');
        }
    }
}
