<?php
namespace Controllers;
use \Core\Controller;
class NotFoundController extends Controller {
    public function index(){
        http_response_code(404);
        $this->loadView('NotFound');
    }
}
?>