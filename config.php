<?php
require 'enviroment.php';
$config =array();
global $config;
if (ENVIROMENT == 'development'){
    define("BASE_URL",'http://localhost/sistema');
    $config['host'] = 'localhost';
    $config['dbname'] = 'acch_banco';
    $config['password'] = '';
    $config['user'] = 'root';
    $config['jwt_validate'] = "198aa52f3b4bdd2539c2c1384f45824e";
}
elseif (ENVIROMENT == 'production'){
    define("BASE_URL",'http://localhost/sistema');
    $config['host'] = '';
    $config['dbname'] = '';
    $config['password'] = '';
    $config['user'] = '';
    $config['jwt_validate'] = "";
}
/**
 * @var PDO 
 */
global $db;
try{
    $db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'],$config['user'],$config['password']);
}catch (PDOException $e){
    echo $e->getMessage();
}
?>