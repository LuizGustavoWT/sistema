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
use function PHPSTORM_META\elementType;

class FuncionarioController extends Controller
{
    private $funcionario;
    private $lancamentos;
    private $user;
    private $centroDeCusto;

    public function __construct()
    {
        $this->funcionario = new Funcionarios();
        $this->lancamentos = new Lancamentos();
        $this->user = new Usuarios();
        $this->centroDeCusto = new CentroDeCusto();
    }

    public function index($id = null)
    {
        $ret = array('erro' => '');
        $method = $this->getMethod();
        $dados = $this->getRequestData();
        $header = $this->getHeader();
        $token = (isset($header['Authorization']) && !empty($header['Authorization'])) ? $header['Authorization'] : $_SESSION['jwt'];

        if ($this->user->isLoged($token)) {
            if ($method == 'GET') {
                $this->loadView('novoFuncionario');
            } else if ($method == "POST") {

                $msg = $this->validateFuncionariosCadastro($dados['nome'],
                    $dados['cpd'],
                    $dados['centrodecusto']);

                if (is_bool($msg) && $msg) {
                    if ($this->funcionario->novoFuncionario($dados['nome'],
                        $dados['cpd'],
                        $dados['centrodecusto'])) {
                        $ret['sucesso'] = "Colaborador cadastrado com sucesso";
                        unset($ret['erro']);
                    } else {
                        $ret['erro'] = "Erro ao cadastrar colaborador";
                    }
                } else {
                    $ret['erro'] = $msg;
                }


                $this->returnJson($ret);
            } else if ($method == "DELETE") {
                if (isset($id) && !empty($id)) {
                    if ($this->funcionario->buscarFuncionarioID($id)) {
                        if ($this->funcionario->deletarFuncionario($id)) {
                            $ret['sucesso'] = "Colaborador excluido com sucesso";
                            unset($ret['erro']);
                        } else {
                            http_response_code(404);
                            $ret['erro'] = "Não foi possivel deletar funcionário";
                        }
                    } else {
                        http_response_code(404);
                        $ret['erro'] = "Funcionário não encontrado";
                    }
                } else {
                    $ret['erro'] = "ID não informado";
                }
                $this->returnJson($ret);
            }
        } else {
            http_response_code(401);
            $ret['erro'] = "Token Inválido";
            $this->returnJson($ret);
        }
    }

    public function desligar($id)
    {
        $ret = array('erro' => '');
        $method = $this->getMethod();
        $dados = $this->getRequestData();
        $header = $this->getHeader();
        $token = (isset($header['Authorization']) && !empty($header['Authorization'])) ? $header['Authorization'] : $_SESSION['jwt'];

        if ($this->user->isLoged($token)) {
            if ($method == "GET") {
                if (isset($id) && !empty($id)) {
                    $func = $this->funcionario->buscarFuncionarioID($id);
                    if ($func) {
                        $this->returnJson($func);
                    } else {
                        http_response_code(404);
                        $ret['erro'] = "Funcionário não encontrado";
                    }
                } else {
                    $ret['erro'] = "ID deve ser Informada";
                }
            }else if($method == "DELETE"){

                if($this->funcionario->buscarFuncionarioID($id)){
                    if ($this->funcionario->demitirFuncionario($id)){
                        $ret['sucesso'] = "Colaborador Desligado da Empresa";
                        unset($ret['erro']);
                    }else{
                        $ret['erro'] = "Erro ao desligar o colaborador da Empresa";
                    }
                }else {
                    http_response_code(404);
                    $ret['erro'] = "Funcionário não encontrado";
                }
            }
            $this->returnJson($ret);
        } else {
            $ret['erro'] = "Token Invalido";
        }
    }


    public function atualizar($id)
    {
        $ret = array('erro' => '');
        $method = $this->getMethod();

        //$this->returnJson($this->getRequestData());

        $dados = $this->getRequestData();
        $header = $this->getHeader();
        $token = (isset($header['Authorization']) && !empty($header['Authorization'])) ? $header['Authorization'] : $_SESSION['jwt'];

        if ($this->user->isLoged($token)) {
            if ($method == "GET") {
                if (isset($id) && !empty($id)) {
                    $func = $this->funcionario->buscarFuncionarioID($id);
                    if ($func) {
                        $arr['cc'] = $this->centroDeCusto->listarCentroDeCusto();
                        $arr['funcionario'] = $func;
                        $this->loadView('editarFuncionario',$arr);
                    } else {
                        http_response_code(404);
                        $ret['erro'] = "Funcionário não encontrado";
                    }
                } else {
                    $ret['erro'] = "ID deve ser Informada";
                }
            } else if ($method == "PUT") {

                if (isset($id) && !empty($id)) {
                    if ($this->funcionario->buscarFuncionarioID($id)) {
                        $msg = $this->validateFuncionariosAtualizacao($dados['nome'], $dados['cpd'], $dados['centrodecusto']);

                        if (is_bool($msg) && $msg) {
                            if ($this->funcionario->atualizarDadosFuncionario($dados['nome'], $dados['cpd'], $dados['centrodecusto'], $id)) {
                                $ret['sucesso'] = "Colaborador atualizado com sucesso";
                                unset($ret['erro']);
                            } else {
                                $ret['erro'] = "Erro ao Atualizar colaborador";
                            }
                        } else {
                            $ret['erro'] = $msg;
                        }
                    } else {
                        http_response_code(404);
                        $ret['erro'] = "Funcionário não encontrado";
                    }
                } else {
                    $ret['erro'] = "ID deve ser Informada";
                }
                $this->returnJson($ret);
            }

        }
    }

    public function selecionar($id)
    {
        $ret = array('erro' => '');
        $method = $this->getMethod();
        $dados = $this->getRequestData();
        $header = $this->getHeader();
        $token = (isset($header['Authorization']) && !empty($header['Authorization'])) ? $header['Authorization'] : $_SESSION['jwt'];

        if ($this->user->isLoged($token)) {
            if ($method == "GET") {
                if (isset($id) && !empty($id)) {
                    $func = $this->funcionario->buscarFuncionarioID($id);
                    if ($func) {
                        $this->returnJson($func);
                    } else {
                        http_response_code(404);
                        $ret['erro'] = "Funcionário não encontrado";
                    }
                } else {
                    $ret['erro'] = "ID deve ser Informada";
                }
            }
        } else {
            $ret['erro'] = "Token Invalido";
        }

    }

    public function listar(){
        $ret = array('erro' => '');
        $method = $this->getMethod();
        $header = $this->getHeader();
        $token = (isset($header['Authorization']) && !empty($header['Authorization'])) ? $header['Authorization'] : $_SESSION['jwt'];
        if($this->user->isLoged($token)){
            if($method == "GET"){
                $ret = $this->funcionario->listarFuncionarios();
                $arr['funcionarios'] = $ret;
                $this->loadView('listarFuncionarios',$arr);
            }
        }else{
            $ret['erro'] = "Token inválido";
        }
    }

    /**
     * @param $nome String
     * @param $cpd Int
     * @param $centroDeCusto ID valido centro de custo
     * @return bool|string
     */
    private
    function validateFuncionariosCadastro($nome, $cpd, $centroDeCusto)
    {
        if (isset($nome) && !empty($nome)) {
            if (isset($cpd) && !empty($cpd)) {
                if (!($this->funcionario->buscarFuncionario($cpd))) {
                    if (isset($cpd) && !empty($cpd)) {
                        if (($this->centroDeCusto->buscarCentroDeCusto($centroDeCusto))) {
                            return true;
                        } else {
                            return 'Centro de custo incorreto!';
                        }
                    } else {
                        return 'Centro de custo deve ser informado!';
                    }
                } else {
                    return 'Funcionário já cadastrado!';
                }
            } else {
                return 'CPD deve ser informado!';
            }
        } else {
            return 'Nome deve ser informado!';
        }
    }

    private
    function validateFuncionariosAtualizacao($nome, $cpd, $centroDeCusto)
    {
        if (isset($nome) && !empty($nome)) {
            if (isset($cpd) && !empty($cpd)) {

                if (isset($cpd) && !empty($cpd)) {
                    if (($this->centroDeCusto->buscarCentroDeCusto($centroDeCusto))) {
                        return true;
                    } else {
                        return 'Centro de custo incorreto!';
                    }
                } else {
                    return 'Centro de custo deve ser informado!';
                }

            } else {
                return 'CPD deve ser informado!';
            }
        } else {
            return 'Nome deve ser informado!';
        }
    }
}