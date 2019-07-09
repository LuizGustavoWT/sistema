<?php

namespace Models;

use Core\Model;

class Lancamentos extends Model
{

    private $historico;
    private $tipoHora;
    private $funcionario;

    public function __construct()
    {
        $this->historico = new Historico();
        $this->tipoHora = new TipoHora();
        $this->funcionario = new Funcionarios();
    }

    public function lancarHoras($id, $qtdHoras, $tipoHora, $idUser)
    {
        $hora = $this->tipoHora->listarTiposID($tipoHora);
        $segundos = $this->calcularSegundos($qtdHoras);
        if($this->historico->novoRegistro($qtdHoras,$id, $idUser, $tipoHora)){
            if($this->atualizarSaldo($id,$segundos,$hora['porcentagem'])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function atualizarSaldo($id, $segundos, $fator)
    {
        $sql = "UPDATE funcionario SET saldo = SEC_TO_TIME(TIME_TO_SEC(saldo) + (?*?)) WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $segundos);
        $sql->bindValue(2, $fator);
        $sql->bindValue(3, $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function corrigirLancamento($id){
        $historico = $this->historico->selecionarMovimento($id);
        if($historico){
            $hora = $this->tipoHora->listarTiposID($historico['id_tipo_hora']);
            $segundos = $this->calcularSegundos($historico['qtd_horas']);
            $fator = ($hora['porcentagem'] * -1);
            if($this->atualizarSaldo($historico['id_funcionario'], $segundos, $fator)){
                if($this->historico->corrigirHistorico($id)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    protected function calcularSegundos($qtHoras)
    {

        list($horas, $minutos) = explode(":", $qtHoras);

        return ($horas * 60 * 60) + ($minutos * 60);

    }
}