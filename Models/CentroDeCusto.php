<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 07/06/2019
 * Time: 15:33
 */

namespace Models;
use \PDO;
use \Core\Model;

class CentroDeCusto extends Model
{

    public function listarCentroDeCusto(){
        $sql = "SELECT * FROM centro_de_custo";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function novoCentroDeCusto($codigo, $centroDeCusto){
        $sql = "INSERT INTO centro_de_custo  VALUES (?, ?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $codigo);
        $sql->bindValue(2, trim(strtoupper($centroDeCusto)));
        $sql->execute();
        if($this->db->lastInsertId() > 0 ){
            return true;
        }else{
            return false;
        }
    }

    public function buscarCentroDeCusto($id){
        $sql = "SELECT * FROM centro_de_custo WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        if ($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function buscarCentroDeCustoPorCodigo($cod){
        $sql = "SELECT * FROM centro_de_custo WHERE cod_cc = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $cod);
        $sql->execute();

        if ($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }


    public function atualizaCentroDeCustos($id, $descricao, $codigo)
    {
        $sql = "UPDATE centro_de_custo SET cod_cc = ?, descricao = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $codigo);
        $sql->bindValue(2, trim(mb_strtoupper($descricao)));
        $sql->bindValue(3, $id);
    }

    public function deletarCentroDeCustos($id){

    }


}