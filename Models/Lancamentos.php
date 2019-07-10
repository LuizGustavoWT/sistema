<?php

namespace Models;

use PDO;
use Core\Model;

class Lancamentos extends Model
{


    public function lancarHoras($id, $qtdHoras, $fator)
    {
        $segundos = $this->calcularSegundos($qtdHoras);
        if($this->atualizarSaldo($id, $segundos, $fator)){
            return true;
        }else{
            return false;
        }
    }

    public function atualizarSaldo($id, $segundos, $fator)
    {

        $sql = "UPDATE funcionario SET saldo = SEC_TO_TIME(TIME_TO_SEC(saldo) + (? * ?)) WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, ($segundos ));
        $sql->bindValue(2, $fator);
        $sql->bindValue(3, $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function calcularSegundos($qtHoras)
    {

        list($horas, $minutos) = explode(":", $qtHoras);

        return ($horas * 60 * 60) + ($minutos * 60);

    }
}