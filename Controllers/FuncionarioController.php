<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 18/06/2019
 * Time: 14:04
 */

namespace Controllers;


use Core\Controller;
use Models\CentroDeCusto;
use Models\Funcionarios;
use Models\Lancamentos;
use Models\Usuarios;

class FuncionarioController extends Controller
{
    private $funcionario;
    private $lancamentos;
    private $user;
    private $centroDeCusto;

    public function __construct(){
        $this->funcionario = new Funcionarios();
        $this->lancamentos = new Lancamentos();
        $this->user = new Usuarios();
        $this->centroDeCusto = new CentroDeCusto();
    }

    public function index(){
        $ret = array('erro' => '');
        $method = $this->getMethod();
        $dados = $this->getRequestData();
        $header = $this->getHeader();
        $token = (isset($header['Authorization']) && !empty($header['Authorization']))? $header['Authorization']: $_SESSION['jwt'];

        if($this->user->isLoged($token)) {
            if ($method == 'GET') {
                $this->loadView('novoFuncionario');
            }
            else if ($method == "POST"){
                $msg = $this->validateFuncionarios($dados['nome'], $dados['cpd'], $dados['centrodecusto']);

                if(is_bool($msg) && $msg){
                    if($this->funcionario->novoFuncionario($dados['nome'], $dados['cpd'],$dados['centrodecusto'])){
                        $ret['sucesso'] = "Colaborador cadastrado com sucesso";
                        unset($ret['erro']);
                    }else{
                        $ret['erro'] = "Erro ao cadastrar colaborador";
                    }
                }else{
                    $ret['erro'] = $msg;
                }
                $this->returnJson($ret);
            }else if($method == "PUT"){
                $msg = $this->validateFuncionarios($dados['nome'], $dados['cpd'], $dados['centrodecusto']);

                if(is_bool($msg) && $msg){
                    if($this->funcionario->atualizarDadosFuncionario($dados['nome'], $dados['cpd'],$dados['centrodecusto']))
                    {
                        $ret['sucesso'] = "Colaborador atualizado com sucesso";
                        unset($ret['erro']);
                    }
                    else{
                        $ret['erro'] = "Erro ao Atualizar colaborador";
                    }
                }else{
                    $ret['erro'] = $msg;
                }
                $this->returnJson($ret);
            }
        }
    }

    private function validateFuncionarios($nome, $cpd, $centroDeCusto){
        if(isset($nome) && !empty($nome)){
            if(isset($cpd) && !empty($cpd)){
                if(!($this->funcionario->buscarFuncionario($cpd))){
                    if(isset($cpd) && !empty($cpd)) {
                        if (!($this->centroDeCusto->buscarCentroDeCusto($centroDeCusto))) {
                            return true;
                        } else {
                            return 'Centro de custo incorreto!';
                        }
                    }else{
                        return 'Centro de custo deve ser informado!';
                    }
                }else{
                    return 'Funcionário já cadastrado!';
                }
            }else{
                return 'CPD deve ser informado!';
            }
        }else{
            return 'Nome deve ser informado!';
        }
    }

}