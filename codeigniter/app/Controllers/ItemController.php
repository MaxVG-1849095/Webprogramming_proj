<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\MessageModel;
use App\Models\NotificationModel;
use App\Models\OrderModel;
use App\Models\ReviewModel;

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
    //redirect to edit wares
    public function editWaresRedirect(){
        return redirect()->to('/editwares');
    }
    public function editWares(){
        $session = session();
        $itemmodel = new ItemModel();
        if ( !$session->has('id') | $session->get('slug') != 'Seller') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        log_message('error', $session->get('id'));
        $data['wares'] = $itemmodel->getItemsSellerid($session->get('id'));

        $this->template('Profile/wareEdit', $data);
    }
    //redirect to edit a ware
    public function wareEditorRedirect($itemid){
        $redirectString = "wareeditor/".$itemid;
        //print_r($redirectString);
        return redirect()->to($redirectString);
    }
    //loads page to edit a ware
    public function wareEditor($itemid){
        $session = session(); //otherwise session data is lost?
        $itemmodel = new ItemModel();
        $data['item'] = $itemmodel->getItems($itemid);
        $ordermodel = new OrderModel();
        
        if ( !$session->has('id') | $session->get('slug') != 'Seller'| empty($data['item'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $data['itemid'] = $itemid;
        $ordermodel = new OrderModel();
        $data['activeorders'] = $ordermodel->getActiveOrderCountItem($itemid);
        $data['inactiveorders'] = $ordermodel->getInactiveOrderCountItem($itemid);
        $data['finishedorders'] = $ordermodel->getFinishedOrderCountitem($itemid);
        $this->template('Profile/wareEditor',$data);
    }
    //updates name of a ware
    public function updatename()
    {
        $session = session();
        if ( empty($this->request->getPost('itemid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
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
    //redirect to create item page
    public function createItemRedirect(){
        return redirect()->to('/createitem');
    }
    //loads view to create item
    public function createItemViewLoader(){
        $session = session();
        $data = [];
        if ( !$session->has('id') | $session->get('slug') != 'Seller') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $this->template("/Profile/wareCreator",$data);
    }
    
    //creates an item
    public function createItem(){
        $session = session();
        $itemmodel = new ItemModel();
        if ( empty($this->request->getPost('name'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
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
            $name = $file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($file)
                ->resize(350, 350, true, 'height')
                ->save(ROOTPATH .'public/Images/Items/'. $name);
            //$file->move(ROOTPATH .'public/Images/Items');
            $itemmodel->insert([
                'name' => $this->request->getPost('name'),
                'description'  => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'filename' => $name,
                'availability' => $this->request->getPost('availability'),
                'sellerid' => $this->request->getPost('sellerid'),
            ]);
        }
        else{
            $session->setFlashdata('itemError', 'Something went wrong, check if you entered everything correctly!');
            
            return $this->createItemRedirect();
            
        }
        $data = [];
        return redirect()->to('/editwares');
    }
    //deletes an item from the database
    public function removeItem(){
        $session = session();
        $model = new ItemModel();
        if ( empty($this->request->getPost('itemid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $item_id = $this->request->getPost('itemid'); 
        $notimodel = new NotificationModel();
        $ordermodel = new OrderModel();
        $activeshoppers = $ordermodel->getActiveItemShoppers($item_id);
        $ordermodel
        ->where(['itemid'=>$item_id, 'finished' =>0])->delete();
        foreach($activeshoppers as $activeshopper){
            $notimodel->insert([
                'content' => "Your order on item " . $item_id . " has been cancelled because the item was deleted from our website. You can contact user with id " . $_SESSION['id'] . " for more information!",
                'userid' => $activeshopper['shopperid'],
                'itemid' => $item_id,
            ]);
        }
        log_message('error', 'in item deleter');
        log_message('error', $item_id);
        $model
            ->wherein('itemid',[$item_id])
            ->delete();
        $data = [];
        
        return redirect()->to('/editwares');
    }
    //sets new availability for an item
    public function setAvailability(){
        $session = session();
        $model = new ItemModel();
        if ( empty($this->request->getPost('itemid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $item_id = $this->request->getPost('itemid'); 

        if ($this->request->getMethod() === 'post' && $this->validate([
            'availability' => 'required',
        ])) {

        $model
            ->wherein('itemid',[$item_id])
            ->set(['availability' => $this->request->getPost('availability')])
            ->update();
        }



        $redirectString = "/wareeditor/". $this->request->getPost('itemid');
        //print_r($redirectString);
        return redirect()->to($redirectString);
    }

    //updates description of an item
    public function updatedescription(){
        $session = session();
        if ( empty($this->request->getPost('itemid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
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
        $redirectString = "/wareeditor/". $this->request->getPost('itemid');
        //print_r($redirectString);
        return redirect()->to($redirectString);
    }
    //updates price of an item
    public function updateprice()
    {
        $session = session();
        if ( empty($this->request->getPost('itemid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
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
        $redirectString = "/wareeditor/". $this->request->getPost('itemid');
        //print_r($redirectString);
        return redirect()->to($redirectString);
    }
    //updates availability of an item
    public function updateavailability()
    {
        $session = session();
        if ( empty($this->request->getPost('itemid'))) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Currently not allowed to take this action');
        }
        $item_id = $this->request->getPost('itemid');
        
        $model = new ItemModel();
        if ($this->request->getMethod() === 'post' && $this->validate([
            'newavailable' => 'required',
        ])) {
            
            $model
            ->wherein('itemid',[$item_id])
            ->set(['availability' => $this->request->getPost('newavailable')])
            ->update();
        }
        $ordermodel = new OrderModel();
        $notimodel = new NotificationModel();
        $counter = $this->request->getPost('newavailable');
        while($counter > 0 && $ordermodel->getFirstInactive($item_id) != null){
            $order = $ordermodel->getFirstInactiveShopper($item_id);
            $item = $model->getItems($item_id);
            $ordermodel
            ->where(['itemid' => $item_id, 'orderid' => $ordermodel->getFirstInactive($item_id)])
            ->set(['active' => 1])
            ->update();
            $model->decrementavailability($item_id);
            $counter = $counter - 1;

            $notimodel->insert([
                'content' => "Your order on " . $item['name'] . " has started, you can still cancel it if you want to!",
                'userid' => $order['shopperid'],
                'itemid' => $item['itemid'],
            ]);
        }

        $redirectString = "/wareeditor/". $this->request->getPost('itemid');
        //print_r($redirectString);
        return redirect()->to($redirectString);
    }

    private function decrementavailability($itemid){
        $model = new ItemModel();

        $model->decrementavailability($itemid);
    }
    private function incrementavailability($itemid){
        $model = new ItemModel();

        $model->incrementavailability($itemid);
    }
    
}
