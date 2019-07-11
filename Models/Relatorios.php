<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 11/07/2019
 * Time: 10:09
 */

namespace Models;

use PDO;
use Core\Model;

class Relatorios extends Model
{
    public function saldoPorFuncinario()
    {
        $sql = "SELECT nome, saldo, cpd, c3.cod_cc, c3.descricao  
FROM funcionario 
JOIN centro_de_custo c3 on funcionario.id_centro_de_custo = c3.id 
ORDER BY nome ASC, c3.cod_cc DESC";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        if ($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
}