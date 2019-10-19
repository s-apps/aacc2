<?php

class Mod_usuario extends CI_Model {

    public function getUsuario($email, $senha){
        $this->db->where('email', $email);
        $usuario = $this->db->get('usuario')->row_array();
        if($email == $usuario['email']){
            if(password_verify($senha, $usuario['senha'])){
                return $usuario;
            }
        }
        return false;
    }
}