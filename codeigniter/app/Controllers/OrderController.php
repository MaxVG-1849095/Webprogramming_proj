<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\NotificationModel;
use App\Models\OrderModel;
use App\Models\UserMediaModel;
use App\Models\UsersModel;
use CodeIgniter\Session\Session;

class OrderController extends BaseController
{
    function __construct()
    {
        //parent::__construct();
    }



    public function makeOrdersFromCart()
    {
        $session = Session();

        $orders = $session->get('cart');

        $cartsize = count($orders);
        for ($i = 0; $i < $cartsize; $i++) {
            for($j = 0; $j < $orders[$i]['amount']; $j++){
                $this->placeorder($orders[$i]['itemid']);
            }
        }
        unset($_SESSION['cart']);
        // $itemid = $this->request->getPost('itemid');

        // $itemmodel = new ItemModel();

        // $item = $itemmodel->getItems($itemid);

        // if ($this->request->getPost('delivery') == "Pickup at store") {
        //     $del = "0";
        // } else {
        //     $usermodel = new UsersModel();
        //     $del = $usermodel->getUserAdress($_SESSION['id'])['adress'];
        // }

        // if ($item['availability'] > 0) {
        //     $this->placeorderavailable($del);
        // } else {
        //     $this->placeorderunavailable($del);
        // }
    }

    public function placeorder($itemid){
        $itemmodel = new ItemModel();

        $item = $itemmodel->getItems($itemid);

        if ($this->request->getPost('delivery') == "Pickup at store") {
            $del = "0";
        } else {
            $usermodel = new UsersModel();
            $del = $usermodel->getUserAdress($_SESSION['id'])['adress'];
        }

        if ($item['availability'] > 0) {
            $this->placeorderavailable($del, $itemid);
        } else {
            $this->placeorderunavailable($del, $itemid);
        }
    }

    public function placeorderavailable($del, $itemid)
    {
        $session = Session();

        $itemmodel = new ItemModel();

        $item = $itemmodel->getItems($itemid);

        $ordermodel = new OrderModel();

        $ordermodel->insert([
            'shopperid' => $_SESSION['id'],
            'sellerid' => $item['sellerid'],
            'itemid' => $item['itemid'],
            'active' => '1',
            'finished' => '0',
            'delivery' => $del,
        ]);

        $itemcontr = new ItemController();
        $itemcontr->decrementavailability($itemid);
    }

    public function placeorderunavailable($del, $itemid)
    {
        $session = Session();

        $itemmodel = new ItemModel();

        $item = $itemmodel->getItems($itemid);

        $ordermodel = new OrderModel();

        $ordermodel->insert([
            'shopperid' => $_SESSION['id'],
            'sellerid' => $item['sellerid'],
            'itemid' => $item['itemid'],
            'active' => '0',
            'finished' => '0',
            'delivery' => $del,
        ]);
    }

    public function loadOrdersSeller()
    {
        $session = session();
        $ordermodel = new OrderModel();
        $usermodel = new UsersModel();

        $shopperids = $ordermodel->getShopperUserIds([$_SESSION['id']]);
        $shopperarray[] = [];
        foreach ($shopperids as $sid) {
            array_push($shopperarray, $usermodel->getUserandID($sid));
        }
        array_shift($shopperarray);

        $itemmodel = new ItemModel();
        $itemids = $ordermodel->getSellerItemids([$_SESSION['id']]);
        $itemarray[] = [];
        foreach ($itemids as $iid) {
            array_push($itemarray, $itemmodel->getItems($iid));
        }
        array_shift($itemarray);
        $data = [
            'shoppers' => $shopperarray,
            'activeorders' => $ordermodel->getActiveSellerOrders($_SESSION['id']),
            'inactiveorders' => $ordermodel->getInactiveSellerOrders($_SESSION['id']),
            'items' => $itemarray,
            'totalOrders' => $ordermodel->getTotalOrderCount($_SESSION['id']),
            'activeOrders' => $ordermodel->getActiveOrderCount($_SESSION['id']),
            'inactiveOrders' => $ordermodel->getInactiveOrderCount($_SESSION['id']),
            'finishedOrders' => $ordermodel->getFinishedOrderCount($_SESSION['id']),
        ];
        $this->template('Profile/sellerOrders', $data);
    }

    public function loadOrdersShopper()
    {
        $session = session();
        $itemmodel = new ItemModel();
        $ordermodel = new OrderModel();
        $usermodel = new UsersModel();
        $sellerids = $ordermodel->getSellerUserIds([$_SESSION['id']]);
        $sellerarray[] = [];
        foreach ($sellerids as $sid) {
            array_push($sellerarray, $usermodel->getUserandID($sid));
        }
        array_shift($sellerarray);

        $itemids = $ordermodel->getShopperItemids($_SESSION['id']);
        $itemarray[] = [];
        foreach ($itemids as $iid) {
            array_push($itemarray, $itemmodel->getItems($iid));
        }
        array_shift($itemarray);

        $data = [
            'items' => $itemarray,
            'activeorders' => $ordermodel->getActiveShopperOrders($_SESSION['id']),
            'inactiveorders' => $ordermodel->getInactiveShopperOrders($_SESSION['id']),
            'sellers' => $sellerarray,
        ];
        $this->template('Profile/shopperOrders', $data);
    }


    public function removeActiveOrderSeller()
    {
        $session = session();
        $ordermodel = new OrderModel();
        $order_id = $this->request->getPost('orderid');
        $shopperid = $ordermodel->getShopperid($order_id);
        $ordermodel
            ->wherein('orderid', [$order_id])
            ->delete();
        $notimodel = new NotificationModel();

        $notimodel->insert([
            'content' => "Your order on item " . $this->request->getPost('itemid') . " has been cancelled. You can contact user with id " . $_SESSION['id'] . " for more information!",
            'userid' => $shopperid['shopperid'],
            'itemid' => $this->request->getPost('itemid'),
        ]);
        $this->setFirstPendingActive($this->request->getPost('itemid'));

        $this->loadOrdersSeller();
    }

    public function removeActiveOrderShopper()
    {
        $session = session();
        $ordermodel = new OrderModel();
        $order_id = $this->request->getPost('orderid');

        $sellerid = $ordermodel->getsellerid($order_id);

        $ordermodel
            ->wherein('orderid', [$order_id])
            ->delete();

            $notimodel = new NotificationModel();

        $notimodel->insert([
            'content' => "The order on item " . $this->request->getPost('itemid') . " has been cancelled. You can contact user with id " . $_SESSION['id'] . " for more information!",
            'userid' => $sellerid['sellerid'],
            'itemid' => $this->request->getPost('itemid'),
        ]);

        $this->setFirstPendingActive($this->request->getPost('itemid'));

        $this->loadOrdersShopper();
    }

    public function removePendingOrderSeller()
    {
        $session = session();
        $ordermodel = new OrderModel();
        $order_id = $this->request->getPost('orderid');
        $shopperid = $ordermodel->getShopperid($order_id);
        $ordermodel
            ->wherein('orderid', [$order_id])
            ->delete();


        $notimodel = new NotificationModel();

        $notimodel->insert([
            'content' => "Your pending order on item " . $this->request->getPost('itemid') . " has been cancelled. You can contact user with id " . $_SESSION['id'] . " for more information!",
            'userid' => $shopperid['shopperid'],
            'itemid' => $this->request->getPost('itemid'),
        ]);

        $this->loadOrdersSeller();
    }

    public function removePendingOrderShopper()
    {
        $session = session();
        $ordermodel = new OrderModel();
        $order_id = $this->request->getPost('orderid');

        $ordermodel
            ->wherein('orderid', [$order_id])
            ->delete();
        $this->loadOrdersShopper();
    }

    public function completeOrder()
    {
        $session = session();
        $ordermodel = new OrderModel();
        $orderid = $this->request->getPost('orderid');
        $shopperid = $ordermodel->getShopperid($orderid);
        $ordermodel
            ->where(['orderid' => $orderid])
            ->set(['active' => 0, 'finished' => 1])
            ->update();
        $notimodel = new NotificationModel();
        $itemmodel = new ItemModel();
        $item = $itemmodel->getItems($this->request->getPost('itemid'));
        if ($this->request->getPost('delivery') == "0") {
            $notimodel->insert([
                'content' => "Your order on " . $item['name'] . " has been completed and is ready for pickup, could you please leave a review for this item?",
                'userid' => $shopperid['shopperid'],
                'itemid' => $item['itemid'],
                'attachment' => 1,
            ]);
        } else {
            $notimodel->insert([
                'content' => "Your order on " . $item['name'] . " has been completed and has arrived at " . $this->request->getPost('delivery') . ", could you please leave a review for this item?",
                'userid' => $shopperid['shopperid'],
                'itemid' => $item['itemid'],
                'attachment' => 1,
            ]);
        }
        $this->loadOrdersSeller();
    }

    public function setFirstPendingActive($itemid)
    {
        $session = session();
        $ordermodel = new OrderModel();
        $notimodel = new NotificationModel();
        $itemmodel = new ItemModel();
        if ($ordermodel->getFirstInactive($itemid) != null) {
            $notimodel->insert([
                'content' => "Your order on " . $itemmodel->getItems($itemid)['name'] . " has started, you can still cancel it if you want to!",
                'userid' => $ordermodel->getFirstInactiveShopper($itemid)['shopperid'],
                'itemid' => $itemid,
            ]);
            $ordermodel
                ->where(['itemid' => $itemid, 'orderid' => $ordermodel->getFirstInactive($itemid)])
                ->set(['active' => 1])
                ->update();
        } else {
            $itemmodel = new ItemModel();
            $itemmodel->incrementavailability($itemid);
        }
    }


    public function orderdateredirect()
    {
        $session = session();
        $itemmodel = new ItemModel();
        $ordermodel = new OrderModel();
        $data = [
            'item' => $itemmodel->getItems($this->request->getPost('itemid')),
            'order' => $ordermodel->getOrder($this->request->getPost('orderid')),
        ];
        $this->template('Profile/orderDate', $data);
    }

    public function setWaitingDate()
    {
        $sesion = session();

        $ordermodel = new OrderModel();

        $ordermodel
            ->where(['orderid' => $this->request->getPost('orderid')])
            ->set(['waitingDate' => 1])
            ->update();
        $this->loadOrdersSeller();
    }

    public function createOrderTime()
    {
        $session = session();
        $ordermodel = new OrderModel();

        log_message('error', $this->request->getPost('orderid'));
        log_message('error', $this->request->getPost('time'));
        log_message('error', $this->request->getPost('date'));

        $ordermodel
            ->where(['orderid' => $this->request->getPost('orderid')])
            ->set(['waitingDate' => 0, 'ordertime' => $this->request->getPost('time'), 'orderdate' => $this->request->getPost('date')])
            ->update();

        $this->loadOrdersShopper();
    }

    public function addOrderToCart($itemid, $amount)
    {
        $session = session();
        //if (!in_array($this->request->getPost('itemid'), $session->get('cart'))) {
            if ($session->has('cart')) {
                $cartarr = $session->get('cart');
                $cartsize = count($cartarr);
                for ($x = 0; $x < $cartsize; $x++) {
                    if($cartarr[$x]['itemid'] === $itemid){
                        unset($cartarr[$x]);
                        $cartarr = array_values($cartarr);
                        break;
                    }
                }
                $newarr = array(
                    'itemid' => $itemid,
                    'amount' => $amount
                );
                array_push($cartarr, $newarr);

                $session->set('cart',$cartarr);
            } else {
                $cartarr[] = array();
                $newarr = array(
                    'itemid' => $itemid,
                    'amount' => $amount
                );
                
                array_push($cartarr, $newarr);
                array_shift($cartarr);
                $session->set('cart', $cartarr);
            }
        //}
        
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    public function ajaxOrderCart(){
        $notimodel = new NotificationModel();

        $notimodel->insert([
            'content' => "Ajax is goed gelukt",
            'userid' => 1,
            'itemid' => 1,
        ]);
        // $data = $this->request->getVar();

        // echo json_encode(array(
        //     "status" => 1,
        //     "message" => "Succesfull request",
        //     "data" => $data
        // ));
    }

    public function loadCartView(){
        $session = session();
        $items_arr[] = [];
        $itemmodel = new ItemModel();
        if($session->has('cart')){
            $price = 0;
            foreach($session->get('cart') as $order){
                $item = $itemmodel->getItems($order['itemid']);
                $price = $price + ($order['amount'] * $item['price']);
                array_push($items_arr, $item);
            }
            array_shift($items_arr);
            $data = [
                'items' => $items_arr,
                'price' => $price
            ];
            
            
        }
        else{
            $data = [];
        }
            
        $this->template('Items/OrderCart', $data);
    }
}
