<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 03/07/2019
 * Time: 17:15
 */

namespace Controllers;

use \Core\Controller;
use \Models\CentroDeCusto;
use \Models\Funcionarios;
use Models\Historico;
use \Models\Lancamentos;
use \Models\TipoHora;
use \Models\Usuarios;

class LancamentoController extends Controller
{

    private $funcionario;
    private $lancamentos;
    private $user;
    private $centroDeCusto;
    private $hora;
    private $historico;

    public function __construct()
    {
        $this->funcionario = new Funcionarios();
        $this->lancamentos = new Lancamentos();
        $this->user = new Usuarios();
        $this->centroDeCusto = new CentroDeCusto();
        $this->hora = new TipoHora();
        $this->historico = new Historico();
    }

    public function lancar($id)
    {
        $ret = array('erro' => '');
        $method = $this->getMethod();
        $dados = $this->getRequestData();
        $header = $this->getHeader();
        $token = (isset($header['Authorization']) && !empty($header['Authorization'])) ? $header['Authorization'] : $_SESSION['jwt'];
        $user = $this->user->isLoged($token);
        if ($user) {
            if ($method == "GET") {
                if (isset($id) && !empty($id)) {
                    $func = $this->funcionario->buscarFuncionarioComCentroDeCusto($id);
                    $hora = $this->hora->listarTipos();
                    if ($func) {
                        $data['funcionario'] = $func;
                        $data['horas'] = $hora;
                        $this->loadView('lancarHoras', $data);
                    } else {
                        http_response_code(404);
                        $ret['erro'] = "Funcionário não encontrado";
                    }
                } else {
                    $ret['erro'] = "ID deve ser Informada";
                }
            }
            else if ($method == "POST") {
                if (isset($id) && !empty($id)) {
                    $func = $this->funcionario->buscarFuncionarioComCentroDeCusto($id);
                    if ($func) {
                        $msg = $this->validarLancamento($dados['qtdHoras'], $dados['tipoHora'], $user['id']);
                        if (is_bool($msg) && $msg) {
                            if ($this->lancamentos->lancarHoras($id, $dados['qtdHoras'], $dados['tipoHora'], $user['id'])) {
                                $ret['sucesso'] = "Lançamento Efetuado";
                                unset($ret['erro']);
                            }
                        } else {
                            $ret['erro'] = $msg;
                        }
                        $this->returnJson($ret);
                    } else {
                        http_response_code(404);
                        $ret['erro'] = "Funcionário não encontrado";
                    }
                } else {
                    $ret['erro'] = "ID deve ser Informada";
                }

            }
            else if ($method == "DELETE") {
                if (isset($id) && !empty($id)) {
                    $hist = $this->historico->selecionarMovimento($id);
                    if ($hist) {
                        $msg = $this->validarLancamento($dados['qtdHoras'], $dados['tipoHora'], $user['id']);
                        if (is_bool($msg) && $msg) {
                            if ($this->lancamentos->lancarHoras($id, $dados['qtdHoras'], $dados['tipoHora'], $user['id'])) {
                                $ret['sucesso'] = "Lançamento Efetuado";
                                unset($ret['erro']);
                            }
                        } else {
                            $ret['erro'] = $msg;
                        }
                        $this->returnJson($ret);
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

    protected function validarLancamento($qtdHoras, $idHora, $idUser)
    {
        if (isset($qtdHoras) && !empty($qtdHoras)) {
            if (isset($idHora) && !empty($idHora)) {
                if ($this->hora->listarTiposID($idHora)) {
                    if (isset($idUser) && !empty($idUser)) {
                        if ($this->user->usuarioId($idUser)) {
                            return true;
                        } else {
                            return "Usuário Invalido";
                        }
                    } else {
                        return "Usuário Não Informado";
                    }
                } else {
                    return "Tipo da Hora Não encontrado";
                }
            } else {
                return "Informe O Tipo Da Hora";
            }
        } else {
            return "Informe Uma Quantidade De Horas";
        }
    }
}