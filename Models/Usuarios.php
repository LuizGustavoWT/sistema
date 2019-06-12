<?php

namespace Models;

use Core\Model;
use \PDO;

class Usuarios extends Model{

    public function isLoged(){

    }

    public function login($user, $password){

    }

    public function listarUsuarios(){

        $sql = "SELECT * FROM usuarios";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function novoUsuario($user, $password){

        $sql = "INSERT INTO usuarios (usuario, senha) VALUES (?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $user);
        $sql->bindValue(2, md5($password));
        $sql->execute();

        if($this->db->lastInsertId() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function usuarioExistente($user){
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $user);
        $sql->execute();
        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function desabilitarUsuario($id){
        $sql = "UPDATE usuarios SET situacao = 0 WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();
        if ($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }



    
}
