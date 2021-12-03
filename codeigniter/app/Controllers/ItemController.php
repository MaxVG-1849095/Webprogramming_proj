<?php

namespace App\Controllers;

use App\Models\ItemModel;

class ItemController extends BaseController
{
    function __construct()
    {
        //parent::__construct();
    }
    public function onItemClick()
    {
    }

    public function orderItem($itemid = 0)
    {
        
    }
    public function editWares(){
        $session = session();
        $itemmodel = new ItemModel();
        log_message('error', $session->get('id'));
        $data['wares'] = $itemmodel->getItemsSellerid($session->get('id'));

        $this->template('Profile/wareEdit', $data);
    }
    public function wareEditor($itemid){
        $session = session(); //otherwise session data is lost?
        $data['itemid'] = $itemid;
        $itemmodel = new ItemModel();
        $data['item'] = $itemmodel->getItems($itemid);
        $this->template('Profile/wareEditor',$data);
    }

    public function updatename()
    {
        $session = session();
        
        $item_id = $this->request->getPost('itemid');
        log_message('error', $item_id);
        $model = new ItemModel();
        if ($this->request->getMethod() === 'post' && $this->validate([
            'newname' => 'required',
        ])) {
            
            $model
            ->wherein('itemid',[$item_id])
            ->set(['name' => $this->request->getPost('newname')])
            ->update();
        }
        $data['itemid'] = $item_id;
        $data['item'] = $model->getItems($item_id);
        $this->template('Profile/wareEditor',$data);
    }
    
    public function createItemRedirect(){
        $session = session();
        $data = [];
        $this->template("/Profile/wareCreator",$data);
    }
    public function createItem(){
        $session = session();
        $itemmodel = new ItemModel();
        if($this->request->getPost('availability') === 'Currently available'){
            $availability = 1;
        }
        else{
            $availability = 0;
        }
        
        if ($this->request->getMethod() === 'post'&& $this->validate([
            'name' => 'required|max_length[128]',
            'description'  => 'required',
            'price' => 'required',
            'availability' => 'required',
        ]) && $this->validate([
            'media_file' => 
            'uploaded[media_file]',
            'mime_in[media_file,image/jpg,image/jpeg,image/gif,image/png]',
            'max_size[media_file,4096]',
        ])){
            $file = $this->request->getFile('media_file');
            $file->move(ROOTPATH .'public/Images/Items');
            $itemmodel->insert([
                'name' => $this->request->getPost('name'),
                'description'  => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'filename' => $file->getName(),
                'availability' => $availability,
                'sellerid' => $this->request->getPost('sellerid'),
            ]);
        }
        else{
            print_r('something went wrong');
            return;
        }
        $data = [];
        $this->editWares();
    }
    public function removeItem(){
        $session = session();
        $model = new ItemModel();
        $item_id = $this->request->getPost('itemid'); 
        log_message('error', 'in item deleter');
        log_message('error', $item_id);
        $model
            ->wherein('itemid',[$item_id])
            ->delete();
        $data = [];
        $this->editWares();
    }

    public function setAvailability(){
        log_message('error', 'in availabilitysetter');

        $session = session();
        $model = new ItemModel();
        $item_id = $this->request->getPost('itemid'); 

        if ($this->request->getMethod() === 'post' && $this->validate([
            'availability' => 'required',
        ])) {

        $model
            ->wherein('itemid',[$item_id])
            ->set(['availability' => $this->request->getPost('availability')])
            ->update();
        }
        $this->wareEditor($item_id);
    }
    public function updatedescription(){
        $session = session();
        
        $item_id = $this->request->getPost('itemid');
        $model = new ItemModel();
        if ($this->request->getMethod() === 'post' && $this->validate([
            'newdesc' => 'required',
        ])) {
            
            $model
            ->wherein('itemid',[$item_id])
            ->set(['description' => $this->request->getPost('newdesc')])
            ->update();
        }
        $this->wareEditor($item_id);
    }
    public function updateprice()
    {
        $session = session();
        
        $item_id = $this->request->getPost('itemid');
        log_message('error', "in update price");
        log_message('error', $this->request->getPost('itemid'));
        $model = new ItemModel();
        if ($this->request->getMethod() === 'post' && $this->validate([
            'newprice' => 'required',
        ])) {
            
            $model
            ->wherein('itemid',[$item_id])
            ->set(['price' => $this->request->getPost('newprice')])
            ->update();
        }
        $this->wareEditor($item_id);
    }
}
