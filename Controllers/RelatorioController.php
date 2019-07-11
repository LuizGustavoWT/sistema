<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 11/07/2019
 * Time: 10:07
 */

namespace Controllers;


use Core\Controller;
use Models\CentroDeCusto;
use Models\Funcionarios;
use Models\Lancamentos;
use Models\Relatorios;
use Models\TipoHora;
use Models\Usuarios;

class RelatorioController extends Controller
{
    private $funcionario;
    private $lancamentos;
    private $user;
    private $centroDeCusto;
    private $hora;
    private $relatorios;

    public function __construct()
    {
        $this->funcionario = new Funcionarios();
        $this->lancamentos = new Lancamentos();
        $this->user = new Usuarios();
        $this->centroDeCusto = new CentroDeCusto();
        $this->hora = new TipoHora();
        $this->relatorios = new Relatorios();
    }

    public function saldo()
    {
        $ret = array('erro' => '');
        $method = $this->getMethod();
        $dados = $this->getRequestData();
        $header = $this->getHeader();
        $token = (isset($header['Authorization']) && !empty($header['Authorization'])) ? $header['Authorization'] : $_SESSION['jwt'];

        if ($this->user->isLoged($token)) {
            if ($method == "GET") {

                $relatorio = $this->relatorios->saldoPorFuncinario();
                if ($relatorio) {
                    $data['funcionarios'] = $relatorio;
                    $this->loadView('saldoPorFuncionario', $data);
                } else {
                    http_response_code(404);
                    $ret['erro'] = "Sem Funcionários Cadastrados";
                }

            } else if ($method == "POST") {

                $relatorio = $this->relatorios->saldoPorFuncinario();

                if ($relatorio) {
                    $nomeArquivo = $this->gerarExcel($relatorio);
                    $this->baixarRelatorio($nomeArquivo);
                } else {
                    http_response_code(404);
                    $ret['erro'] = "Sem Funcionários Cadastrados";
                }
            }
        } else {
            http_response_code(401);
            $ret['erro'] = "Token Invalido";
        }
    }

    protected function baixarRelatorio($filename = ""){
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize("Assets/relatorios/" . $filename));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');
        flush();
        // Envia o arquivo para o cliente
        readfile('Assets/relatorios/' . $filename);
        unlink('Assets/relatorios/' . $filename);

    }

    public function gerarExcel($ret){
        $nome = md5(time().rand(0,99)).".csv";
        $file = "Assets/relatorios/".$nome;
        $f = fopen($file,"a+");

        for($i = 0; $i < count($ret); $i++){

            if ($i == 0) {
                fwrite($f, implode(";", array_keys($ret[$i])) . "\n");
            }
            fwrite($f, implode(";", array_values($ret[$i])) . "\n");

        }
        fclose($f);
        return $nome;
    }
}


