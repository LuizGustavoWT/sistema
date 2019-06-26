<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 09/06/2019
 * Time: 23:15
 */

namespace Models;

use PDO;
use Core\Model;

class Historico extends Model
{

    public function __construct()
    {

    }

    public function novoRegistro($qtdeHoras,$idFuncionario, $idUsuario, $tipoDeHora){
        $sql = "INSERT INTO historico (id_funcionario, data_mov, qtd_horas, id_tipo_hora, id_usuario) VALUES (?, NOW(),?,?,?)";
        $sql =$this->db->prepare($sql);
        $sql->bindValue(1, $idFuncionario);
        $sql->bindValue(2, $qtdeHoras);
        $sql->bindValue(3, $tipoDeHora);
        $sql->bindValue(4, $idUsuario);
        $sql->execute();
        if ($this->pdo->lastInsertId() > 0)
        {
            return true;
        }else{
            return false;
        }
    }



}