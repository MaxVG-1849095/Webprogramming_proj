<?php

namespace App\Controllers;

use App\Models\UserMediaModel;
use CodeIgniter\Controller;
use App\Models\UsersModel;

class ProfileController extends BaseController
{
    function __construct()
    {
        //parent::__construct();
    }
    public function index($profid = 0)
    {
        $session=session();
        $model = new UsersModel();
        log_message('error',$profid);
        if($profid === 0){
            
            $data = [
                'user'  => $model->getUsers($_SESSION['id']),
                'title' => 'Users archive',
            ];
            $usermediamodel = new UserMediaModel();
            $data['media'] = $usermediamodel->getUserMedia($_SESSION['id']);
    }
        else{
            
            $data = [
                'user'  => $model->getUsers($profid),
                'title' => 'Users archive',
            ];
            $usermediamodel = new UserMediaModel();
            $data['media'] = $usermediamodel->getUserMedia($profid);
        }

        echo view('templates/header', $data);
        echo view('Profile/profile', $data);
        echo view('templates/footer', $data);
    }
    function logout()
    {
        $session = session();
        $session->remove('email');
        $session->remove('id');
        $session->remove('name');
        $session->remove('cart');
        $logincont = new LoginController();
        return $logincont->index();
    }
    public function edit()
    {
        $model = new UsersModel();
        $session = session();

        $session_id = $session->get('id');
        log_message('error', $session_id);

        $data['user'] = $model->getUsers($session_id);
        // echo view('templates/header', $data);
        // echo view('Login/profileEdit', $data);
        // echo view('templates/footer', $data);
        $this->template('Profile/profileEdit', $data);
    }
    public function editdesc()
    {
        log_message('error', $this->request->getMethod());
        $session = session();

        $session_id = $session->get('id');
        $model = new UsersModel();
        if ($this->request->getMethod() === 'post' && $this->validate([
            'newdesc' => 'required',
        ])) {
            log_message('error', 'in editdesc if');
            $data = [
                'description' => $this->request->getPost('newdesc'),
            ];
            $model->update($session_id, $data);
        }
        return $this->edit();
    }

    public function editadress()
    {
        $session = session();

        $session_id = $session->get('id');
        $model = new UsersModel();
        if ($this->request->getMethod() === 'post' && $this->validate([
            'newadress' => 'required',
        ])) {
            log_message('error', 'in editdesc if');
            $data = [
                'adress' => $this->request->getPost('newadress'),
            ];
            $model->update($session_id, $data);
        }
        return $this->edit();
    }

    
}
