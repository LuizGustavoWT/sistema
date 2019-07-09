<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 03/07/2019
 * Time: 12:41
 */

namespace Models;
use \Core\Model;
use \PDO;

class TipoHora extends Model
{

    public function listarTipos(){
        $sql = "SELECT * FROM tipo_hora";
        $sql = $this->db->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function listarTiposID($id){
        $sql = "SELECT * FROM tipo_hora WHERE id = ?";
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