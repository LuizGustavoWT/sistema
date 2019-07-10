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

    public function novoRegistro($qtdeHoras,$idFuncionario, $idUsuario, $tipoDeHora){
        $this->db->beginTransaction();
        $sql = "INSERT INTO historico (id_funcionario, data_mov, qtd_horas, id_tipo_hora, id_usuario) VALUES (?, NOW(),?,?,?)";
        $sql =$this->db->prepare($sql);
        $sql->bindValue(1, $idFuncionario);
        $sql->bindValue(2, $qtdeHoras);
        $sql->bindValue(3, $tipoDeHora);
        $sql->bindValue(4, $idUsuario);
        $sql->execute();
        if ($this->db->lastInsertId() > 0)
        {
            $this->db->commit();
            return true;
        }else{
            return false;
        }
    }

    public function apagarRegistro($id){
        $sql = "DELETE FROM historico WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function corrigirHistorico($id){
        $sql = "UPDATE historico SET status = 0";
        $sql = $this->db->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function listarHistoricoFuncionario($idFuncionario)
    {
        $sql = "SELECT h.descricao as tipo_hora, historico.qtd_horas, historico.id, data_mov FROM historico
JOIN funcionario f on historico.id_funcionario = f.id
JOIN tipo_hora h on historico.id_tipo_hora = h.id
WHERE id_funcionario = ? AND status = 1 ORDER BY data_mov LIMIT 10";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $idFuncionario);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function selecionarMovimento($id){
        $sql = "SELECT * FROM historico WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

}