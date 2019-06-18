<?php 

namespace Controllers;

use Core\Controller;
use Models\JWT;
use Models\Usuarios;


class LoginController extends Controller{


    private $jwt;

    public function __construct()
    {
        $this->jwt = new JWT();
    }

    public function index(){
        $this->loadView("Login");
    }

    public function login(){
        $dados = $this->getRequestData();
        $retorno = array('error' => '');
        if($this->getMethod() == "POST"){
            $usuario = new Usuarios();
            if(isset($dados['username']) && !empty($dados['password'])) {
                if(isset($dados['password']) && !empty($dados['password'])) {
                    $user = $usuario->login($dados['username'], $dados['password']);
                    if ($user) {
                         $user['expiration'] = date('d/m/Y H:i:s', strtotime('+ 7 days'));
                        unset($user['senha']);
                        $token = $this->jwt->create($user);
                        http_response_code(200);
                        $retorno['token'] = $token;
                        $_SESSION['jwt'] = $token;
                        $this->returnJson($retorno);
                    }else{
                        http_response_code(401);
                        $retorno['error'] = "Usuario Ou Senha Invalidos";
                        $this->returnJson($retorno);
                    }
                }
            }else{
                $this->returnJson($retorno);
            }
        }

    }

    public function sair(){
        $ret['jwt'] = "";
        session_destroy();
        session_start();
        $this->returnJson($ret);
    }


}