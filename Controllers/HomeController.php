<?php

namespace Controllers;
use Core\Controller;
use Models\JWT;
use Models\Usuarios;

class HomeController extends Controller
{

    private $jwt;
    private $user;


    public function __construct(){
        $this->jwt = new JWT();
        $this->user = new Usuarios();
    }

    public function index(){

        $headers = $this->getHeader();


        if(isset($_SESSION['jwt']) && !empty($_SESSION['jwt'])){
            $u = $this->user->isLoged($_SESSION['jwt']);
            if ($u){
                $this->loadView('index');
            }
        }else{
            header("Location: ". BASE_URL."/login");
        }

    }

}