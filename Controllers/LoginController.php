<?php 

namespace Controllers;

use Core\Controller;

class LoginController extends Controller{
    
    public function index(){
        $this->loadView("Login");
    }
    
}