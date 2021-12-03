<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
    class Test extends BaseController {
        function __construct()
        {
            //parent::__construct();
        }
    public function index() { 
        $this->load->helper('url'); 
        $this->load->view('test'); 
    } 
} 
?>