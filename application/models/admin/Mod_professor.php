<?php

class Mod_professor extends CI_Model {

    public function listar($limit, $offset, $sort, $order, $search, $total = false) {
        $this->db->where('nivel', 0);
        if (!empty($search)) {
            $this->db->where("(nome LIKE '%$search%' OR email LIKE '%$search%')", null, false);
        }
        if ($total) {
            return $this->db->count_all_results('usuario');
        }
        $this->db->order_by($sort, $order);
        return $this->db->get('usuario', $limit, $offset)->result_array();
    }

    public function salvar($acao, $usuario_id, $nome, $email, $senha, $cursos) {
        if ($acao == 'adicionar') {
            $this->db->select('email');
            $this->db->where('email', $email);
            $num_rows = $this->db->count_all_results('usuario');
            if ($num_rows == 0) {
                $this->db->set('nome', $nome);
                $this->db->set('email', $email);
                $this->db->set('senha', $senha);
                $this->db->set('nivel', 0);
                $this->db->insert('usuario');
                $insert_id = $this->db->insert_id();
                $this->inserirCursos($insert_id, $cursos);
                return true;
            }else{
                return false;
            }
        } elseif ($acao == 'editar') {
            $this->db->select('usuario_id, email');
            $this->db->where('email', $email);
            $resultado = $this->db->get('usuario')->row_array();
            if ($resultado['usuario_id'] == $usuario_id && $resultado['email'] == $email) {
                $this->inserirCursos($usuario_id, $cursos);
                $this->db->set('nome', $nome);
                $this->db->set('email', $email);
                if (isset($senha)) {
                    $this->db->set('senha', $senha);
                }
                $this->db->where('usuario_id', $usuario_id);
                return $this->db->update('usuario');
            } else {
                $this->db->select('email');
                $this->db->where('email', $email);
                $num_rows = $this->db->count_all_results('usuario');
                if ($num_rows == 0) {
                    $this->inserirCursos($usuario_id, $cursos);
                    $this->db->set('nome', $nome);
                    $this->db->set('email', $email);
                    if (isset($senha)) {
                        $this->db->set('senha', $senha);
                    }
                    $this->db->where('usuario_id', $usuario_id);
                    return $this->db->update('usuario');
                }
            }
        }
        return false;
    }

    public function inserirCursos($usuario_id, $cursos) {
        $this->db->where('professor_id', $usuario_id);
        $this->db->delete('professor_leciona');
        if(isset($cursos)){
            foreach ($cursos as $curso) {
                $this->db->set('professor_id', $usuario_id);
                $this->db->set('curso_id', $curso);
                $this->db->insert('professor_leciona');
            }
        }
    }
    
    public function getById($usuario_id){
        $this->db->where("usuario_id", $usuario_id);
        return $this->db->get("usuario")->row_array();
    }    

    public function excluir($ids){
        $this->db->trans_begin();
        $this->db->where_in('usuario_id', $ids);
        $this->db->delete('usuario');
        $this->db->where_in('professor_id', $ids);
        $this->db->delete('professor_leciona');
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
        }
        return $this->db->trans_status();
    }
    
}
