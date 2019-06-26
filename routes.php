<?php
global $rotas;

$rotas = array();

// ROTAS LOGIN
$rotas['/'] = '/home/index';
$rotas['/login'] = '/login/index';
$rotas['/logar'] = '/login/login';
$rotas['/sair'] = '/login/sair';

// ROTAS FUNCIONARIOS

$rotas['/funcionario'] = '/funcionario/index';
//$rotas['/funcionario/{id}'] = '/funcionario/index/:id';
$rotas['/funcionarios/demitir/{id}'] = '/funcionario/desligar/:id';
$rotas['/funcionarios/editar/{id}'] = '/funcionario/atualizar/:id';
$rotas['/funcionarios/selecionar/{id}'] = '/funcionario/selecionar/:id';
$rotas['/funcionarios/listar'] = '/funcionario/listar';




?>