<?php
/**
 * Created by PhpStorm.
 * User: gusta
 * Date: 11/06/2019
 * Time: 21:02
 */

namespace Models;


use Core\Model;
use Models\Historico;

class Lancamentos extends Model
{



    protected function calcularSegundos($qtHoras){

        list($horas,$minutos) = explode(":",$qtHoras);

        return ($horas*60*60) + ($minutos*60);

    }

}