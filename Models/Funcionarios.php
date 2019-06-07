<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 07/06/2019
 * Time: 14:28
 */

namespace Models;

use \PDO;
use \Core\Model;

class Funcionarios extends Model
{

    public function listarFuncionarios(){
        $sql = "SELECT * FROM funcionarios";
        $sql = $this->db->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function novoFuncionario($nome, $cpd, $centroDeCusto){
        $sql = "INSERT INTO funcionarios (cpd, nome, id_centro_de_custo) VALUES (?,?,?)";

    }

    public function saldoTotalBanco(){
        $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(funcionarios.saldo))) as saldoTotal FROM funcionarios";

        $sql = $this->db->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
    public function saldoTotalBancoPorCentroDeCusto($cc){
        $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(funcionarios.saldo))) as total FROM funcionarios WHERE id_centro_de_custo = ((SELECT id FROM centro_de_custo WHERE centro_de_custo.cod_cc = ?) )";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $cc);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }





}