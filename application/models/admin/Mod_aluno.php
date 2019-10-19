<?php

class Mod_aluno extends CI_Model {

    public function listar($limit, $offset, $sort, $order, $search, $total = false){
        $this->db->where('nivel', 1);
        if(!empty($search)){
             $this->db->where("(nome LIKE '%$search%' OR aluno_ra LIKE '%$search%' OR email LIKE '%$search%')", null, false);
        }
        if($total){
            return $this->db->count_all_results('usuario');    
        }
	    $this->db->order_by($sort, $order);
        return $this->db->get('usuario', $limit, $offset)->result_array();
    }

    public function salvar($acao, $aluno_ra, $usuario_id, $nome, $email, $senha, $curso_id){
        if($acao == 'adicionar'){
            $this->db->where('email', $email);
            $num_rows = $this->db->count_all_results('usuario');
            if($num_rows == 0){
                $this->db->set('nome', $nome);
                $this->db->set('email', $email);
                $this->db->set('senha', $senha);
                $this->db->set('aluno_ra', $aluno_ra);
                $this->db->set('curso_id', $curso_id);
                $this->db->set('nivel', 1);
                return $this->db->insert('usuario');
            }
        }elseif($acao == 'editar'){
            $this->db->select('usuario_id, email');
            $this->db->where('email', $email);
            $resultado = $this->db->get('usuario')->row_array();
            if($resultado['usuario_id'] == $usuario_id && $resultado['email'] == $email){
                $this->db->set('nome', $nome);
                $this->db->set('email', $email);
                $this->db->set('senha', $senha);
                $this->db->set('aluno_ra', $aluno_ra);
                $this->db->set('curso_id', $curso_id);
                $this->db->set('nivel', 1);
                $this->db->where('usuario_id', $usuario_id);
                return $this->db->update('usuario');
            }else{
                $this->db->select('email');
                $this->db->where('email', $email);
                $num_rows = $this->db->count_all_results('usuario');
                if($num_rows == 0){
                    $this->db->set('nome', $nome);
                    $this->db->set('email', $email);
                    $this->db->set('senha', $senha);
                    $this->db->set('aluno_ra', $aluno_ra);
                    $this->db->set('curso_id', $curso_id);
                    $this->db->set('nivel', 1);
                    $this->db->where('usuario_id', $usuario_id);
                    return $this->db->update('usuario');
                }
            }
        }
        return false;
    }
    
    public function getById($usuario_id){
        $this->db->where("usuario_id", $usuario_id);
        return $this->db->get("usuario")->row_array();
    }   
    
    public function getAll(){
        $this->db->where('nivel', 1);
        $this->db->order_by('nome');
        return $this->db->get('usuario')->result_array();
    }
    
    public function excluir($ids){
        $this->db->where_in("usuario_id", $ids);
        $this->db->delete("usuario");
        return $this->db->affected_rows();
    }
    
    public function getHorasRealizadas($aluno_ra, $validacao){
        $this->db->where('aluno_ra', $aluno_ra);
        $this->db->where('validacao', intval($validacao));
        $atividades = $this->db->get('atividade')->result_array();
        foreach ($atividades as &$atividade){
            $atividade['data'] = mysqlToView($atividade['data']);
        }
        return $atividades;
    }
}
