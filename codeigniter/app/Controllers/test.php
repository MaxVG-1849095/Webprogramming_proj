<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
    class Test extends Controller {
	
    public function index() { 
        $this->load->helper('url'); 
        $this->load->view('test'); 
    } 
} 
?>