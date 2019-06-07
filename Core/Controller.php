<?php
namespace Core;
class Controller{
    public function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getRequestData(){

        switch ($this->getMethod()){
            case 'GET':
                return $_GET;
                break;
            case 'PUT':
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $dados);
                return (array) $dados;
                break;
            case 'POST':
                $dados = json_decode(file_get_contents("php://input"));
                if (is_null($dados)){
                    $dados = $_POST;
                }
                return (array) $dados;
                break;
        }

    }

    public function returnJson($array){
        header('Content-type: application/json;charset=utf-8');
        echo json_encode($array,448);
        exit;

    }

    public function loadView($viewName, $viewData = array()){
        extract($viewData);
        require  'Views/'.$viewName.'.php';
    }
}
?>