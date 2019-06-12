<?php 

namespace Controllers;

use Core\Controller;
use Models\Usuarios;


class LoginController extends Controller{
    
    public function index(){
        $this->loadView("Login");
    }

    public function login(){
        $dados = $this->getRequestData();

        if($this->getMethod() == "POST"){
            $usuario = new Usuarios();
            $usuario->login($dados['username'], $dados['password']);
            $this->returnJson($dados);
        }

    }
    
}