<?php 

namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UsersModel;

class LoginController extends BaseController
{
    function __construct()
    {
        //parent::__construct();
    }
    public function index()
    {
        helper(['form']); //load in form helper
        echo view('templates/header');
        echo view('Login/login');
        echo view('templates/footer');
    } 
    public function signupRedirect(){
        echo view('templates/header');
        echo view('Login/signup');
        echo view('templates/footer');
    }
    //creates new account in database and logs into that account
    public function signup(){
        $session = session();
        $UsersModel = new UsersModel();
    
        /*
        log_message('error', $this->request->getPost('name'));
        log_message('error', $this->request->getPost('password'));
        log_message('error', $this->request->getPost('email'));
        log_message('error', $this->request->getPost('customertype'));
        log_message('error', $this->request->getPost('description'));
        */
        if ($this->request->getMethod() === 'post'&& $this->validate([
            'name' => 'required|max_length[128]',
            'password'  => 'required|max_length[255]',
            'email' => 'required|max_length[128]|is_unique[Users.email]',
            'description' => 'required',
            'street' => 'required',
            'city' => 'required',
            'housenumber' => 'required'
        ])) {
            $adress = $this->request->getPost('street') . " " . $this->request->getPost('housenumber') . " " . $this->request->getPost("city");
            
            $UsersModel->save([
                'name' => $this->request->getPost('name'),
                'PASSWORD'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'email' => $this->request->getPost('email'),
                'slug' => $this->request->getPost('customertype'),
                'description'  => $this->request->getPost('description'),
                'adress' => $adress,
            ]);
            $data = $UsersModel->getUserLogin($this->request->getVar('email'), $this->request->getVar('password'));
            $ses_data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'id' => $data['id'],
                'slug' => $data['slug']
            ];
            $session->set($ses_data);
            $profContr = new ProfileController();
            return redirect()->to('/profile');
        }
        else{
            $session->setFlashdata('signuperror', 'Something went wrong, check if you entered everything otherwise try a different email');
            
            return redirect()->to('/signup');
        }
    }
    //logs user into their account or tells them that their login is incorrect
    public function login()
    {
        log_message('error', 'in login func');
        $session = session();

        $UsersModel = new UsersModel();

        $email = $this->request->getPost('email'); 
        $password = $this->request->getPost('password');
        log_message('error', 'test');
        $data = $UsersModel->getUserLogin($email, $password);
        log_message('error', $email);
        //log_message('error', $password);
        //log_message('error', 'data vars');
        //log_message('error', $data['name']);
        //log_message('error', $data['PASSWORD']);

        if($data){
            $pass = $data['PASSWORD'];
            
            if(password_verify($password, $pass)){
                $ses_data = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'id' => $data['id'],
                    'slug' => $data['slug']
                ];

                $session->set($ses_data);
                
                $profContr = new ProfileController();
                return redirect()->to('/profile');
            
            }else{
                $session->setFlashdata('loginerror', 'Password is incorrect.');
                //log_message('error', $pass);
                //log_message('error', $password);
                return redirect()->to('login');
                }

        }else{
            $session->setFlashdata('loginerror', 'Email is not in our records.');
            //log_message('error', 'second else block');
            return redirect()->to('login');
        }
    }
}