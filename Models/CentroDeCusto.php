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

}