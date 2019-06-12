<?php

namespace Controllers;
use Core\Controller;
use Models\Categorias;
use Models\InformacoesSite;

class HomeController extends Controller
{

    public function index(){
        $this->loadView('imports');
    }

}