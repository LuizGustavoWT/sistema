<?php
// Sessão 
session_start();

// Libera o CORS e Os métodos HTTP
header("Content-type: text/html; charset=utf-8");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

//header('Content-Type: text/html; charset=utf-8');
require 'config.php';
require 'routes.php';

// PSR4 AutoLoad

spl_autoload_register(function ($class){
    $file = str_replace('\\','/',$class).'.php';

    if (file_exists($file)){
        require($file);
    }
});
// Inicia o CORE da aplicação
$core = new Core\Core();
$core->run();

?>