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
            if(isset($dados['username']) && !empty($dados['password'])) {
                if(isset($dados['password']) && !empty($dados['password'])) {
                    $user = $usuario->login($dados['username'], $dados['password']);
                    if ($user) {
                        $user['expiration'] = strtotime(time(), "+7 days");
                        $token = "";
                        header("Authorization: Basic" . $token);
                    }
                }
            }else{

            }
        }

    }


}